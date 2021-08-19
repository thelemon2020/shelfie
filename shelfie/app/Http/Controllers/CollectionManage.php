<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionManage extends Controller
{
    public function loadPage()
    {
        $user = Auth::user();
        $genres = Genre::query()->where('user_id', $user->id)->orderBy('shelf_order', 'asc')->get();
        return view('manageCollection', ['genres' => $genres]);
    }

    public function updateShelfOrder(Request $request): string
    {
        $genreNames = $request->input('genreNames');
        $genreShelfOrder = $request->input('genreShelfOrder');
        for ($i=0; $i < count($genreNames); $i++){
            $genre = Genre::query()->where('name',$genreNames[$i])->first();
            $genre->shelf_order = $genreShelfOrder[$i];
            $genre->save();
        }
        return redirect(route('collection.manage.index'));
    }
}
