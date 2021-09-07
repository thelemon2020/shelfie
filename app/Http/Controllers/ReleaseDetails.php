<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Release;
use Illuminate\Http\Request;

class ReleaseDetails extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $release = Release::query()->where('id', $id)->first();
        $release['genre'] = Genre::query()->where('id', $release->genre_id)->first()->name;
        return json_encode($release);
    }
}
