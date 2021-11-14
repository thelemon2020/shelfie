<?php

namespace App\Http\Controllers\Release;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Show extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $release = Release::query()->where('id', $id)->first();
        $release->genre = Genre::query()->where('id', $release->genre_id)->first()->name;

        $selectRecord = [
            "seg" => [
                'id' => '0',
                "i" =>
                    [round(($release->shelf_order - 1) / 2), [255, 0, 0]]
            ]];

        Http::asJson()->post('192.168.0.196/json', $selectRecord);
        return json_encode($release);
    }
}
