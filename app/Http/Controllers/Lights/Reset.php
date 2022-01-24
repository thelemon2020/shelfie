<?php

namespace App\Http\Controllers\Lights;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class Reset extends Controller
{
    public function __invoke()
    {
        $state = json_decode(Http::timeout(2)->get(User::all()->first()->userSettings->wled_ip . '/json'), true);
        foreach ($state['seg'] as &$i) {
            $i['stop'] = 0;
        }
        $state['on'] = false;
        Http::timeout(2)->post(User::all()->first()->userSettings->wled_ip . '/json/state', $state);
    }
}
