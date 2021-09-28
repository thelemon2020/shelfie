<?php

namespace App\Http\Controllers\Release\Update;

use App\Http\Controllers\Controller;
use App\Models\Release;

class Show extends Controller
{
    public function __invoke($id)
    {
        $release = Release::query()->where('id', $id)->first();
        return view('editRelease', ['release' => $release]);
    }
}
