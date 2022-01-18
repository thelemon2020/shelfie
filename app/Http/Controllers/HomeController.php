<?php

namespace App\Http\Controllers;

use App\Models\Plays;
use App\Models\Release;
use App\Models\User;

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
        $play = Plays::query()->latest()->first();
        $nowPlaying = Release::query()->where('id', $play?->release_id)->first() ?? null;
        return view('home', ['user' => $user, 'nowPlaying' => $nowPlaying]);
    }

    public function index()
    {
        return view('index');
    }
}
