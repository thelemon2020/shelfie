<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\Release;
use App\Models\ReleaseGenre;
use App\Models\User;
use App\Models\UserRelease;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Ramsey\Uuid\Uuid;

class Loading extends Component
{
    public $currentRelease;

    public function render()
    {
        return view('livewire.loading');
    }

    public function buildCollection()
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
        if (!$user->discogs_username) {
            $this->getUsername($auth, $user);
        }
        $this->getReleases($user, $auth);
        return redirect(route('home'));
    }

    public function getUsername(string $auth, ?Authenticatable $user): void
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $auth,
            'User-Agent' => config('auth.user_agent')
        ])->get('https://api.discogs.com/oauth/identity');
        $usernameArrayElement = explode(': ', $response->body())[2];
        $username = explode('",', $usernameArrayElement)[0];
        $username = str_replace('"', '', $username);
        $user->discogs_username = $username;
        $user->save();
    }

    /**
     * @param Authenticatable|null $user
     * @param array|int|string $genre
     * @param array|string $pageNumber
     * @param string $auth
     */
    public function getReleases(?Authenticatable $user, string $auth): void
    {
        $nextPage = "https://api.discogs.com/users/$user->discogs_username/collection/folders/0/releases?page=1&sort=artist";
        while ($nextPage != null) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $auth,
                'User-Agent' => config('auth.user_agent')
            ])->get($nextPage);
            $releasesArray = json_decode($response->body());
            $nextPage = $releasesArray->pagination->urls->next ?? null;
            $releases = collect($releasesArray->releases);
            $releases->each(function ($item) use ($user) {
                $genres = [];
                Log::info('genres', $item->basic_information->styles);
                array_map(function ($genre) use (&$genres) {
                    $createdGenre = Genre::query()->where('name', $genre)->first();
                    if (!$createdGenre) {
                        $createdGenre = Genre::query()->create([
                            'name' => $genre
                        ]);
                    }
                    $genres[] = $createdGenre;
                }, $item->basic_information->genres);
                $this->currentRelease = Release::query()->updateOrCreate([
                    'uuid' => $item->id,
                    'artist' => $item->basic_information->artists[0]->name,
                    'title' => $item->basic_information->title,
                    'release_year' => $item->basic_information->year,
                    'thumbnail' => $item->basic_information->thumb,
                    'full_image' => $item->basic_information->cover_image,
                ]);
                sleep(.5);
                array_map(function ($genre) {
                    ReleaseGenre::query()->create([
                        'genre_id' => $genre->id,
                        'release_id' => $this->currentRelease->id
                    ]);
                }, $genres);
                UserRelease::query()->updateOrCreate([
                    'user_id' => $user->id,
                    'release_id' => $this->currentRelease->id,
                ]);
            });
        }
    }
}
