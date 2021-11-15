<?php

namespace App\Http\Controllers\Lights\Genre;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Support\Facades\Http;

class Index extends Controller
{
    public function __invoke()
    {
        $genres = Genre::all()->sortBy('shelf_order');
        $position = 0;
        $seg = [];
        foreach ($genres as $genre) {
            $size = round($genre->releases()->count() / 2);
            list($r, $g, $b) = sscanf($genre->colour, "#%02x%02x%02x");
            $segment = [
                'start' => $position,
                'stop' => $position + $size,
                'len' => $size,
                'col' => [[$r, $g, $b], [$r, $g, $b], [$r, $g, $b]],
            ];
            $position += $size;
            $seg[] = $segment;
        }
        $payload = ['seg' => $seg];
        $response = Http::post('192.168.0.196/json', $payload);
        return $response;
    }
}
