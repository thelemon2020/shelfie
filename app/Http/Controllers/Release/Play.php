<?php

namespace App\Http\Controllers\Release;

use App\Http\Controllers\Controller;
use App\Models\Plays;
use App\Models\Release;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class Play extends Controller
{
    public function __invoke($id)
    {
        $release = Release::query()->where('id', $id)->first();

        Plays::query()->create([
            'release_id' => $release->id,
            'genre_id' => $release->genre_id,
        ]);
        Cache::put('now-playing', $release->id);
        return new JsonResponse(['success' => true], 200);
    }
}
