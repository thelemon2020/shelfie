<?php

namespace App\Http\Controllers\Lights\TurnOff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Light extends Controller
{
    public function __invoke()
    {
        $selectRecord = Cache::get('selected-record');
        unset($selectRecord['seg']['i']);
        Http::timeout(2)->asJson()->post(User::all()->first()->userSettings->wled_ip . '/json', $selectRecord);
    }
}
