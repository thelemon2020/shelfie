<?php

namespace App\Http\Controllers\Lights;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class Reset extends Controller
{
    public function __invoke()
    {
        $state = json_decode(Http::get('192.168.0.196/json/state'), true);
        foreach ($state['seg'] as &$i) {
            $i['stop'] = 0;
        }
        $state['on'] = false;
        dd($state);
        Http::post('192.168.0.196/json/state', $state);
    }
}
