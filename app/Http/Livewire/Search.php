<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\LightSegment;
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
                ->join('genre_release', 'releases.id', '=', 'genre_release.release_id')
                ->join('genres', 'genres.id', '=', 'genre_release.genre_id')
                ->where('genres.name', 'LIKE', "%$this->search%")
                ->select(['releases.*', 'genres.name'])
                ->orderBy('genres.name')
                ->orderBy('releases.artist')
                ->paginate($this->pagination);
        } else {
            $releases = Release::query()->where($this->sort, "LIKE", "%$this->search%")->orderBy($this->sort, 'asc')->paginate($this->pagination);
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
            'User-Agent' => config('auth.user_agent')
        ])->get("https://api.discogs.com/users/$user->discogs_username/collection/folders");
        $folders = json_decode($response->body())->folders;
        foreach ($folders as $folder) {
            if ($folder->name == 'Strip') {
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
        $userSettings = \App\Models\UserSettings::query()->first()->get()[0];
        $i = 1;
        $sortOrder = $userSettings->sort_order === 'asc' ? 'desc' : 'asc';
        if ($userSettings->sort_method == "genre_id") {
            Genre::query()->where('name', '!=', 'All')->get()->sortBy('name', null, $userSettings->sort_order == 'desc')->each(function ($genre) use ($sortOrder, &$i, $userSettings, $user, $auth) {
                $nextPage = "https://api.discogs.com/users/$user->discogs_username/collection/folders/$genre->folder_number/releases?page=1&sort=added&sort_order=$sortOrder";
                $this->generateCollectionFromPayload($nextPage, $auth, $user, $i);
            });
            return;
        }
        $sortMethod = $userSettings->sort_method === 'release_year' ? 'year' : $userSettings->sort_method;
        $nextPage = "https://api.discogs.com/users/$user->discogs_username/collection/folders/0/releases?page=1&sort=$sortMethod&sort_order=$sortOrder";
        $this->generateCollectionFromPayload($nextPage, $auth, $user, $i);
        Release::sort();
        if ($userSettings->wled_ip) {
            LightSegment::generateSegments();
        }

    }

    /**
     * @param string|null $nextPage
     * @param $auth
     * @param $user
     * @param int $i
     */
    private function generateCollectionFromPayload(?string $nextPage, $auth, $user, int &$i)
    {
        while ($nextPage != null) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $auth,
                'User-Agent' => config('auth.user_agent')
            ])->get($nextPage);
            $releasesArray = json_decode($response->body());
            $nextPage = $releasesArray->pagination->urls->next ?? null;
            $releases = collect($releasesArray->releases);
            $releases->each(function ($item) use ($user, &$i) {
                $release = Release::query()->where('uuid', $item->id)->first();
                if ($release) {
                    $release->update([
                        'release_year' => $item->basic_information->year,
                        'genre_id' => Genre::query()->where('folder_number', $item->folder_id)->first()->id,
                        'thumbnail' => $item->basic_information->thumb,
                        'full_image' => $item->basic_information->cover_image,
                        'shelf_order' => $i,
                    ]);
                } else {
                    $release = Release::query()->create(
                        [
                            'uuid' => $item->id,
                            'artist' => $item->basic_information->artists[0]->name,
                            'title' => $item->basic_information->title,
                            'release_year' => $item->basic_information->year,
                            'genre_id' => Genre::query()->where('folder_number', $item->folder_id)->first()->id,
                            'thumbnail' => $item->basic_information->thumb,
                            'full_image' => $item->basic_information->cover_image,
                            'shelf_order' => $i,
                        ]);
                }
                $i++;
                UserRelease::query()->updateOrCreate([
                    'user_id' => $user->id,
                    'release_id' => $release->id,
                ]);
            });
        }
    }
}
