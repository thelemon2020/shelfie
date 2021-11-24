<?php


namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\User;
use App\Models\UserSettings;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;


class DiscogsController extends Controller
{

    public function authenticate(Request $request)
    {
        $consumerSecret = config('auth.discogs_API_secret');
        $consumerKey = config('auth.discogs_API_key');
        $authHeader = collect([
            ['oauth_consumer_key', $consumerKey],
            ['oauth_nonce', Uuid::uuid4()->toString()],
            ['oauth_signature', $consumerSecret . '&'],
            ['oauth_signature_method', "PLAINTEXT"],
            ['oauth_timestamp', Carbon::now()->timestamp],
            ['oauth_callback', \route('discogs.callback')],
        ]);

        $auth = 'OAuth ' . $authHeader->map(function (array $header) {
                return implode('=', $header);
            })->implode(',');
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $auth,
                'User-Agent' => 'RecordCollectionDisplay/0.2 +https://github.com/thelemon2020/RecordCollectionDisplay'
            ])->get('https://api.discogs.com/oauth/request_token');
        } catch (\Exception $ex) {
            dd($ex);
        }
        if ($response->status() != 200) {
            return view('auth.register', ['discogsMessage' => 'Could Not Authenticate']);
        }
        $oauthStuff = explode('&', $response->body());
        $oauthToken = str_replace('oauth_token=', '', $oauthStuff[0]);
        Cache::put('Discogs_OAuth_Token', $oauthToken);
        Cache::put('Discogs_OAuth_Secret', str_replace('oauth_token_secret=', '', $oauthStuff[1]));
        return redirect("https://discogs.com/oauth/authorize?oauth_token=$oauthToken");
    }

    public function callback(Request $request)
    {
        $consumerSecret = config('auth.discogs_API_secret');
        $consumerKey = config('auth.discogs_API_key');
        $oauthVerifier = $request->query('oauth_verifier');
        $this->authHeader = collect([
            ['oauth_consumer_key', $consumerKey],
            ['oauth_nonce', Uuid::uuid4()->toString()],
            ['oauth_token', Cache::pull('Discogs_OAuth_Token')],
            ['oauth_signature', $consumerSecret . '&' . Cache::pull('Discogs_OAuth_Secret')],
            ['oauth_signature_method', "PLAINTEXT"],
            ['oauth_timestamp', Carbon::now()->timestamp],
            ['oauth_callback', \route('discogs.callback')],
            ['oauth_verifier', $oauthVerifier]
        ]);
        $auth = 'OAuth ' . $this->authHeader->map(fn(array $header) => implode('=', $header))->implode(',');
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $auth,
            'User-Agent' => 'RecordCollectionDisplay/0.2 +https://github.com/thelemon2020/RecordCollectionDisplay'
        ])->post('https://api.discogs.com/oauth/access_token');
        if ($response->status() != 200) {
            return view('auth.register', ['discogsMessage' => 'Could Not Authenticate']);
        }
        $oauthStuff = explode('&', $response->body());
        $user = User::query()->first();
        if (!$user) {
            $user = User::query()->make();
        }
        $user->discogs_token = str_replace('oauth_token=', '', $oauthStuff[0]);
        $user->discogs_token_secret = str_replace('oauth_token_secret=', '', $oauthStuff[1]);
        if (!$this->getDiscogsUserName($user)) {
            return view('auth.register', ['discogsMessage' => 'Could Not Authenticate']);
        }
        $user->save();
        UserSettings::query()->create([
            'user_id' => $user->id,
        ]);
        return redirect(route('loadingScreen'));
    }

    public function getGenres(string $auth, ?Authenticatable $user): void
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $auth,
            'User-Agent' => config('User-Agent')
        ])->get("https://api.discogs.com/users/$user->discogs_username/collection/folders");
        $folders = json_decode($response->body())->folders;
        foreach ($folders as $key => $folder) {
            if ($folder->name == 'Strip') {
                continue;
            }
            Genre::query()->create([
                    'name' => $folder->name,
                    'folder_number' => $folder->id,
                    'user_id' => $user->id,
                    'shelf_order' => $key + 1
                ]
            );
        }
    }

    public function getDiscogsUserName(User $user)
    {
        try {
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
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $auth,
                'User-Agent' => config('User-Agent')
            ])->get('https://api.discogs.com/oauth/identity');
            $jsonUsername = json_decode($response->body());
            $user->discogs_username = $jsonUsername->username;
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $auth,
                'User-Agent' => config('User-Agent')
            ])->get('https://api.discogs.com/users/' . $user->discogs_username);
            $userDetails = json_decode($response->body());
            $fullName = explode(' ', $userDetails->name);
            $user->firstname = $fullName[0];
            $user->lastname = $fullName[1];
            $user->email = $userDetails->email;
            $user->password = config('auth.defaultPassword');
            $user->save();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
