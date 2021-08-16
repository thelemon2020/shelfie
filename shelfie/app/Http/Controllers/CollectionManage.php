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
}
