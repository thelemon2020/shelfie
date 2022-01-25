<?php

namespace App\Http\Controllers\Release;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Plays;
use App\Models\Release;
use Illuminate\Http\Request;

class Show extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $release = Release::query()->where('id', $id)->first();
        $genre = Genre::query()->where('id', $release->genre_id)->first() ?? null;
        $plays = Plays::query()->where('release_id', $release->id)->orderBy('created_at', 'desc')->get();

        $release->genre = $genre->name ?? 'Uncategorized';
        $release->times_played = count($plays) ?? 0;
        $release->last_played_at = $plays->first()?->created_at?->toDateTimeString() ?? 'Never';
        return json_encode($release);
    }
}
