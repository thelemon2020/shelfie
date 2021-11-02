<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;

class CollectionManage extends Controller
{
    public function loadPage()
    {
        $user = User::query()->first();
        $genres = Genre::query()->where('user_id', $user->id)->orderBy('shelf_order')->get();
        return view('manageCollection', ['genres' => $genres]);
    }

    public function updateShelfOrder(Request $request): string
    {
        $genreNames = $request->input('genreNames');
        $genreShelfOrder = $request->input('genreShelfOrder');
        $genreColour = $request->input('genreColour');
        for ($i = 0; $i < count($genreNames); $i++) {
            $genre = Genre::query()->where('name', $genreNames[$i])->first();
            $genre->shelf_order = $genreShelfOrder[$i];
            $genre->colour = $genreColour[$i];
            $genre->save();
        }
        $this->updateReleaseShelfOrder();
        return redirect(route('collection.manage.index'));
    }

    public function updateReleaseShelfOrder()
    {
        $genres = Genre::all()->sortBy('shelf_order');
        $i = 1;
        foreach ($genres as $genre) {
            $releases = $genre->releases;
            foreach ($releases as $release) {
                $release->shelf_order = $i;
                $release->save();
                $i++;
            }
        }
    }
}
