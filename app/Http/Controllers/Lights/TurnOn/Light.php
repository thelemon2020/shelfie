<?php

namespace App\Http\Controllers\Lights\TurnOn;

use App\Http\Controllers\Controller;
use App\Models\Release;
use Illuminate\Http\Request;

class Light extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $release = Release::query()->where('id', $id)->first();
        $release->turnOnLight();
    }
}
