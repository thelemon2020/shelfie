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
        $genresToUpdate = $request->input('updatedGenres');
        foreach ($genresToUpdate as $genreToUpdate){
            $genre = Genre::query()->where('name',$genreToUpdate[0])->first();
            $genre->shelf_order = $genreToUpdate[1];
            $genre->save();
        }
        return route('collection.manage.index');
    }
}
