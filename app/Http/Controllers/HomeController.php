<?php

namespace App\Http\Controllers;

use App\Models\Plays;
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
            ->take(5)
            ->get();
        $mostPlayed = Plays::query()
            ->join('releases', 'plays.release_id', '=', 'releases.id')
            ->select('releases.artist', 'releases.title', 'releases.full_image', DB::raw("count(*) as times_played"))
            ->groupBy('plays.release_id')
            ->orderBy('times_played', 'DESC')
            ->take(10)
            ->get();
        return view('home', ['user' => $user, 'nowPlaying' => $lastPlayed[0], 'mostPlayed' => $mostPlayed, 'lastPlayed' => $lastPlayed->toArray()]);
    }

    public function index()
    {
        return view('index');
    }
}
