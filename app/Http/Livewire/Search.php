<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\Release;
use App\Models\User;
use App\Models\UserRelease;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Ramsey\Uuid\Uuid;

class Search extends Component
{
    use withPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $sort = 'artist';
    public $pagination = 50;

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function updatingPagination()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->sort == 'genre') {
            $releases = Release::query()
                ->join('genres', 'releases.genre_id', '=', 'genres.id')
                ->where('genres.name', "LIKE", "%$this->search%")
                ->orderBy('genres.name', 'ASC')
                ->paginate($this->pagination);
        } else {
            $releases = Release::query()->where($this->sort, "LIKE", "%$this->search%")->orderBy($this->sort, 'ASC')->paginate($this->pagination);
        }
        return view('livewire.search', [
            'releases' => $releases
        ]);
    }

    public function refreshCollection(): void
    {
        $user = User::query()->first();
        $oauthToken = $user->discogs_token;
        $oAuthSecret = $user->discogs_token_secret;
        $consumerSecret = config('auth.discogs_API_secret');
        $consumerKey = config('auth.discogs_API_key');
        $this->authHeader = collect([
            ['oauth_consumer_key', $consumerKey],
            ['oauth_nonce', Uuid::uuid4()->toString()],
            ['oauth_token', $oauthToken],
            ['oauth_signature', $consumerSecret . '&' . $oAuthSecret],
            ['oauth_signature_method', "PLAINTEXT"],
            ['oauth_timestamp', Carbon::now()->timestamp],
        ]);
        $auth = 'OAuth ' . $this->authHeader->map(fn(array $header) => implode('=', $header))->implode(',');
        $this->refreshGenres($auth, $user);
        $this->refreshReleases($auth, $user);
        $this->render();
    }

    public function refreshGenres(string $auth, $user): void
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $auth,
            'User-Agent' => config('User-Agent')
        ])->get("https://api.discogs.com/users/$user->discogs_username/collection/folders");
        $folders = json_decode($response->body())->folders;
        foreach ($folders as $folder) {
            if ($folder->name == 'All') {
                continue;
            } else if (!Genre::query()->where('folder_number', $folder->id)->first()) {
                Genre::query()->create([
                        'name' => $folder->name,
                        'folder_number' => $folder->id,
                        'user_id' => $user->id
                    ]
                );
            }
        }
    }

    public function refreshReleases($auth, $user)
    {
        $nextPage = "https://api.discogs.com/users/$user->discogs_username/collection/folders/0/releases?page=1&sort=added&sort_order=desc";
        $i = 1;
        while ($nextPage != null) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $auth,
                'User-Agent' => config('User-Agent')
            ])->get($nextPage);
            $releasesArray = json_decode($response->body());
            $nextPage = $releasesArray->pagination->urls->next ?? null;
            $releases = collect($releasesArray->releases);
            $lastUpdatedAt = Release::query()->latest('updated_at')->first()->updated_at;
            $releases->each(function ($item) use ($user, &$i, $lastUpdatedAt, &$nextPage) {
                if ($item->date_added >= $lastUpdatedAt) {
                    $newRelease = Release::query()->create(
                        [
                            'artist' => $item->basic_information->artists[0]->name,
                            'title' => $item->basic_information->title,
                            'release_year' => $item->basic_information->year,
                            'genre_id' => Genre::query()->where('folder_number', $item->folder_id)->first()->id,
                            'thumbnail' => $item->basic_information->thumb,
                            'full_image' => $item->basic_information->cover_image,
                            'shelf_order' => $i,
                        ]);
                    $i++;
                    UserRelease::query()->updateOrCreate([
                        'user_id' => $user->id,
                        'release_id' => $newRelease->id,
                    ]);
                } else {
                    $nextPage = null;
                }
            });
        }
    }
}
