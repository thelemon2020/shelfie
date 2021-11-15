<?php

namespace App\Http\Controllers\Release;

use App\Http\Controllers\Controller;
use App\Models\Release;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Play extends Controller
{
    public function __invoke($id)
    {
        $release = Release::query()->where('id', $id)->first();
        $release->update([
            'times_played' => ++$release->times_played,
            'last_played_at' => Carbon::now()
        ]);

        $selectRecord = Cache::get('selected-record');
        unset($selectRecord['seg']['i']);
        $response = Http::asJson()->post('192.168.0.196/json', $selectRecord);
        return $response;
    }
}
