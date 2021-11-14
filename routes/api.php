<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DiscogsController;
use App\Http\Controllers\Lights\Genre\Index;
use App\Http\Controllers\Release\Delete;
use App\Http\Controllers\Release\Play;
use App\Http\Controllers\Release\Show;
use App\Http\Controllers\Release\Update\Images;
use App\Http\Controllers\Release\Update\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/collection/build', [CollectionController::class, 'buildCollection'])->name('collection.build');

Route::post('/discogs/authenticate', [DiscogsController::class, 'authenticate'])->name('discogs.authenticate');

Route::get('/release/images', Images::class)->name('release.images');

Route::get('/release/{id}', Show::class)->name('release.show');

Route::get('/release/{id}/delete', Delete::class)->name('release.delete');

Route::post("/release/{id}/edit", Update::class)->name('release.edit');

Route::get('/release/{id}/play', Play::class)->name('release.play');

Route::get('/lights/genres', Index::class)->name('lights.genres');



