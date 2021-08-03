<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Release;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

class CollectionController extends Controller
{
    public function retrieveCollection(Request $request)
    {
        $user = Auth::user();
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
            ['oauth_signature', $consumerSecret.'&'. $oAuthSecret],
            ['oauth_signature_method', "PLAINTEXT"],
            ['oauth_timestamp', Carbon::now()->timestamp],
        ]);
        $auth = 'OAuth ' . $this->authHeader->map(fn(array $header) => implode('=', $header))->implode(',');
        if (!$user->discogs_username)
        {
            $this->getUsername($auth, $user);
        }

        if (!Genre::query()->get()->where('user_id', $user->id)->first())
        {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $auth,
                'User-Agent' => 'RecordCollectionDisplay/0.2 +https://github.com/thelemon2020/RecordCollectionDisplay'
            ])->get("https://api.discogs.com/users/$user->discogs_username/collection/folders");

            $folders = json_decode($response->body())->folders;
            foreach($folders as $folder){
                Genre::query()->create([
                'genre'=>$folder->name,
                'folder_number'=>$folder->id,
                        'user_id'=>$user->id
                        ]
                );
            }

        }
        else
        {
            $nextPage = "https://api.discogs.com/users/$user->discogs_username/collection/folders/$genre/releases?page=$pageNumber&sort=artist";
            while($nextPage != null){
                $response = Http::withHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => $auth,
                    'User-Agent' => 'RecordCollectionDisplay/0.2 +https://github.com/thelemon2020/RecordCollectionDisplay'
                ])->get($nextPage);
                $releasesArray = json_decode($response->body());
                $folderNums = collect($releasesArray)->pluck('folder_id');
                $nextPage = $releasesArray->pagination->urls->next;
                $releases = collect($releasesArray->releases)->pluck('basic_information');
                $folderNums->
                dd($releases);
                foreach ($releases as $release)
                {
                    dd($release);
                    $releaseEntry = new  Release([
                        'artist'=>$release['artists'][0],
                        'title'=>$release['title'],
                        'release_year'=>$release['year'],
                        'genre'=> '1',
                        'thumbanil' => ''
                        ]);
                }
            }

            //return view('collection', $response->body());
        }




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
}
