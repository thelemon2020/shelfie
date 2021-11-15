<?php

namespace App\Http\Controllers\Lights;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TurnOffIndividual extends Controller
{
    public function __invoke()
    {
        $selectRecord = Cache::get('selected-record');
        unset($selectRecord['seg']['i']);
        Http::asJson()->post('192.168.0.196/json', $selectRecord);
    }
}
