<?php

namespace App\Http\Controllers;

use App\Models\Plays;
use App\Models\Release;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Stats extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke()
    {
        $user = User::query()->first();
        $play = Plays::query()->latest()->first();
        $lastPlayed = Release::query()->where('id', $play?->release_id)->first() ?? null;
        if ($lastPlayed) {
            $lastPlayed->last_played_at = $play->created_at;
        }
        $mostPlayed = Plays::query()
            ->join('releases', 'plays.release_id', '=', 'releases.id')
            ->select('releases.artist', 'releases.title', 'releases.full_image', DB::raw("count(*) as times_played"))
            ->groupBy('plays.release_id')
            ->orderBy('times_played', 'DESC')
            ->take(10)
            ->get();


        return view('stats', ['user' => $user, 'lastPlayed' => $lastPlayed, 'mostPlayed' => $mostPlayed]);
    }
}
