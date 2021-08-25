<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Release;
use App\Models\User;
use App\Models\UserRelease;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

class CollectionController extends Controller
{
    public function buildCollection(Request $request)
    {
        $user = User::query()->first();
        $oauthToken = $user->discogs_token;
        $oAuthSecret = $user->discogs_token_secret;
        $consumerSecret = config('auth.discogs_API_secret');
        $consumerKey = config('auth.discogs_API_key');
        $pageNumber = $request->query('page') ?: '1';
        $genre = $request->query('genre') ?: 0;
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

        if (Genre::query()->get()->where('user_id', $user->id)->first() === null ) {
            $this->getGenres($auth, $user);

        }
        $this->getReleases($user, $genre, $pageNumber, $auth);
        return response()->json();
    }

    public function showCollection(Request $request)
    {
        $user = User::query()->first();
        $sort = $request->query('sort') ?? 'artist';
        $paginationNumber = ($request->query('pagination')) ?? 50;
        if ($sort == 'genre') {
            $sort = $sort . '.name';
        } else if ($sort == 'shelf_order') {
            $sort = 'genre.shelf_order';
        }
        $releases = $user->releases()->orderByJoin($sort)->paginate((int)$paginationNumber);
        $releases->appends(array('sort' => $sort, 'pagination' => $paginationNumber))->links();

        return view('index', ['releases' => $releases]);
    }

    public function getUsername(string $auth, ?Authenticatable $user): void
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $auth,
            'User-Agent' => 'RecordCollectionDisplay/0.2 +https://github.com/thelemon2020/RecordCollectionDisplay'
        ])->get('https://api.discogs.com/oauth/identity');
        $usernameArrayElement = explode(': ', $response->body())[2];
        $username = explode('",', $usernameArrayElement)[0];
        $username = str_replace('"', '', $username);
        $user->discogs_username = $username;
        $user->save();
    }

    /**
     * @param string $auth
     * @param Authenticatable|null $user
     */
    public function getGenres(string $auth, ?Authenticatable $user): void
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $auth,
            'User-Agent' => 'RecordCollectionDisplay/0.2 +https://github.com/thelemon2020/RecordCollectionDisplay'
        ])->get("https://api.discogs.com/users/$user->discogs_username/collection/folders");
        $folders = json_decode($response->body())->folders;
        foreach ($folders as $folder) {
            if ($folder->name == 'All') {
                continue;
            }
            Genre::query()->create([
                    'name' => $folder->name,
                    'folder_number' => $folder->id,
                    'user_id' => $user->id
                ]
            );
        }
    }

    /**
     * @param Authenticatable|null $user
     * @param array|int|string $genre
     * @param array|string $pageNumber
     * @param string $auth
     */
    public function getReleases(?Authenticatable $user, array|int|string $genre, array|string $pageNumber, string $auth): void
    {
        $nextPage = "https://api.discogs.com/users/$user->discogs_username/collection/folders/$genre/releases?page=$pageNumber&sort=artist";
        $i = 1;
        while ($nextPage != null) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $auth,
                'User-Agent' => 'RecordCollectionDisplay/0.2 +https://github.com/thelemon2020/RecordCollectionDisplay'
            ])->get($nextPage);
            $releasesArray = json_decode($response->body());
            $nextPage = $releasesArray->pagination->urls->next ?? null;
            $releases = collect($releasesArray->releases);
            $releases->each(function ($item, $key) use ($user, &$i) {
                $newRelease = Release::query()->updateOrCreate([
                    'artist' => $item->basic_information->artists[0]->name,
                    'title' => $item->basic_information->title,
                    'release_year' => $item->basic_information->year,
                    'genre_id' => Genre::query()->where('folder_number', $item->folder_id)->first()->id,
                    'thumbnail' => $item->basic_information->thumb,
                    'shelf_order' => $i,
                ]);
                $i++;
                UserRelease::query()->updateOrCreate([
                    'user_id' => $user->id,
                    'release_id' => $newRelease->id,
                ]);
            });
        }
    }
}
