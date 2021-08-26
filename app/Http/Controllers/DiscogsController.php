<?php


namespace App\Http\Controllers;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;


class DiscogsController extends Controller
{

    public function authenticate(Request $request)
    {
        $user = User::all()->first();
        $user->discogs_username = $request->input('username');
        $user->save();
        $consumerKey = 'DtnKgLrTlfWnVIkyirOB';
        $consumerSecret = 'eUydCQVQhzKYDnCBdEQOTLfVWedyIlRa';
        $authHeader = collect([
            ['oauth_consumer_key', $consumerKey],
            ['oauth_nonce', Uuid::uuid4()->toString()],
            ['oauth_signature', $consumerSecret.'&'],
            ['oauth_signature_method', "PLAINTEXT"],
            ['oauth_timestamp', Carbon::now()->timestamp],
            ['oauth_callback', \route('discogs.callback')],
        ]);

        $auth = 'OAuth ' . $authHeader->map(function (array $header) {
                return implode('=', $header);
            })->implode(',');

        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $auth,
            'User-Agent'=> 'RecordCollectionDisplay/0.2 +https://github.com/thelemon2020/RecordCollectionDisplay'
        ])->get('https://api.discogs.com/oauth/request_token');
        $oauthStuff = explode('&',$response->body());
        $oauthToken =str_replace('oauth_token=', '', $oauthStuff[0]);
        session(['Discogs_OAuth_Token' => $oauthToken]);
        session(['Discogs_OAuth_Secret'=> str_replace('oauth_token_secret=', '', $oauthStuff[1])]);
        return redirect("https://discogs.com/oauth/authorize?oauth_token=$oauthToken");
    }

    public function callback(Request $request)
    {
        $consumerKey = 'DtnKgLrTlfWnVIkyirOB';
        $consumerSecret = 'eUydCQVQhzKYDnCBdEQOTLfVWedyIlRa';
        $oauthVerifier =  $request->query('oauth_verifier');
        $this->authHeader = collect([
            ['oauth_consumer_key', $consumerKey],
            ['oauth_nonce', Uuid::uuid4()->toString()],
            ['oauth_token', session('Discogs_OAuth_Token')],
            ['oauth_signature', $consumerSecret.'&'. session('Discogs_OAuth_Secret')],
            ['oauth_signature_method', "PLAINTEXT"],
            ['oauth_timestamp', Carbon::now()->timestamp],
            ['oauth_callback', \route('discogs.callback')],
            ['oauth_verifier', $oauthVerifier]
        ]);
        $auth = 'OAuth ' . $this->authHeader->map(fn (array $header) => implode('=', $header))->implode(',');
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $auth,
            'User-Agent'=> 'RecordCollectionDisplay/0.2 +https://github.com/thelemon2020/RecordCollectionDisplay'
        ])->post('https://api.discogs.com/oauth/access_token');
        $oauthStuff = explode('&',$response->body());
        $user = User::query()->first();
        $user->discogs_token = str_replace('oauth_token=', '', $oauthStuff[0]);
        $user->discogs_token_secret = str_replace('oauth_token_secret=', '', $oauthStuff[1]);
        $user->save();
        if (!$this->checkUserIdentity($user))
        {
            $user->discogs_token = null;
            $user->discogs_token_secret = null;
            $user->discogs_username = null;
            $user->save();
            return route(('collection.index'), ['message'=>'Username did not match authentication attempt']);
        }
        return redirect(route('loadingPage'));
    }

    public function checkUserIdentity(User $user)
    {
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
        $usernameArrayElement = explode(': ', $response->body())[2];
        $username = explode('",', $usernameArrayElement)[0];
        $username = str_replace('"', '', $username);
        if ($user->discogs_username != $username)
        {
            return false;
        }

        return true;
    }
}
