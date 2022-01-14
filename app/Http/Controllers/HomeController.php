<?php

namespace App\Http\Controllers;

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
        $nowPlaying = Release::query()->latest('last_played_at')->whereNotNull('last_played_at')->first();

        return view('home', ['user' => $user, 'nowPlaying' => $nowPlaying]);
    }

    public function index()
    {
        return view('index');
    }
}
