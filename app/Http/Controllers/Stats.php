<?php

namespace App\Http\Controllers;

use App\Models\Release;
use App\Models\User;

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
        $lastPlayed = Release::query()->latest('last_played_at')->whereNotNull('last_played_at')->first();
        $mostPlayed = Release::query()->orderBy('times_played', 'desc')->orderBy('last_played_at', 'desc')->whereNotNull('times_played')->take(5)->get();

        return view('stats', ['user' => $user, 'lastPlayed' => $lastPlayed, 'mostPlayed' => $mostPlayed]);
    }
}
