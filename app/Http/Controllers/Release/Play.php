<?php

namespace App\Http\Controllers\Release;

use App\Http\Controllers\Controller;
use App\Models\Release;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class Play extends Controller
{
    public function __invoke($id)
    {
        $release = Release::query()->where('id', $id)->first();
        $release->update([
            'times_played' => ++$release->times_played,
            'last_played_at' => Carbon::now()
        ]);
        return new JsonResponse(['message' => 'success']);
    }
}
