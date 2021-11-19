<?php

namespace App\Http\Controllers\Release;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Release;
use Illuminate\Http\Request;

class Show extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $release = Release::query()->where('id', $id)->first();
        $genre = Genre::query()->where('id', $release->genre_id)->first() ?? null;
        $release->genre = $genre->name ?? 'Uncategorized';
        $release->turnOnLight();
        return json_encode($release);
    }
}
