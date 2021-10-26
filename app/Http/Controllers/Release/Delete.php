<?php

namespace App\Http\Controllers\Release;

use App\Http\Controllers\Controller;
use App\Models\Release;
use Illuminate\Http\JsonResponse;

class Delete extends Controller
{
    public function __invoke($id)
    {
        Release::query()->where('id', $id)->first()->delete();
        return new JsonResponse(['message' => 'success']);
    }
}
