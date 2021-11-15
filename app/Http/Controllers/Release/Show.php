<?php

namespace App\Http\Controllers\Release;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Release;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Show extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $release = Release::query()->where('id', $id)->first();
        $genre = Genre::query()->where('id', $release->genre_id)->first() ?? null;
        $release->genre = $genre->name ?? 'Uncategorized';
        if (User::query()->first()->userSettings->sort_method === 'artist') {
            $selectRecord = [
                "seg" => [
                    'id' => '0',
                    "i" =>
                        [(int)round(($release->shelf_order - 1) / 2), [255, 255, 255]]
                ]];
        } else {
            $releases = $genre->releases;
            $shelf_order = 0;
            foreach ($releases as $key => $value) {
                if ($value->id === $release->id) {
                    $shelf_order = $key;
                    break;
                }
            }
            $selectRecord = [
                "seg" => [
                    'id' => $genre->shelf_order - 1,
                    "i" =>
                        [
                            (int)round($shelf_order / 2),
                            [255, 255, 255]
                        ]
                ]];
        }
        Cache::put('selected-record', $selectRecord);
        Http::post('192.168.0.196/json', $selectRecord);
        return json_encode($release);
    }
}
