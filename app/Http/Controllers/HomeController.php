<?php

namespace App\Http\Controllers;

use App\Models\Plays;
use App\Models\Release;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $user = User::query()->first();
        $lastPlayed = Plays::query()
            ->join('releases', 'plays.release_id', '=', 'releases.id')
            ->latest('plays.created_at')
            ->select('releases.artist', 'releases.title', 'releases.full_image')
            ->get()
            ->first();
        $nowPlaying = Release::query()->where('id', $lastPlayed[0]?->release_id)->first() ?? null;
        $mostPlayed = Plays::query()
            ->join('releases', 'plays.release_id', '=', 'releases.id')
            ->select('releases.artist', 'releases.title', 'releases.full_image', DB::raw("count(*) as times_played"))
            ->groupBy('plays.release_id')
            ->orderBy('times_played', 'DESC')
            ->take(10)
            ->get();
        return view('home', ['user' => $user, 'nowPlaying' => $nowPlaying, 'mostPlayed' => $mostPlayed, 'lastPlayed' => $lastPlayed]);
    }

    public function index()
    {
        return view('index');
    }
}
