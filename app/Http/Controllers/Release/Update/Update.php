<?php

namespace App\Http\Controllers\Release\Update;

use App\Http\Controllers\Controller;
use App\Models\Release;
use Illuminate\Http\Request;

class Update extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $release = Release::query()->where('id', $id)->first();
        var_dump($release->toArray());
        $release->artist = $request->input('artist');
        $release->title = $request->input('title');
        $release->shelf_order = $request->input('shelf_order');
        $release->thumbnail = $request->input('thumbnail');
        $release->full_image = $request->input('full_image');
        dd($release->toArray());
        $release->save();
    }
}
