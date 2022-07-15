<?php

use App\Http\Controllers\DiscogsController;
use App\Http\Controllers\Lights\Toggle;
use App\Http\Controllers\Lights\TurnOff\Light;
use App\Http\Controllers\Lights\TurnOn\All;
use App\Http\Controllers\Lights\TurnOn\Segments;
use App\Http\Controllers\Lights\TurnOn\Strip;
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

Route::get('/release/nowplaying', \App\Http\Controllers\Release\NowPlaying\Index::class)->name('now-playing');

Route::post('/discogs/authenticate', [DiscogsController::class, 'authenticate'])->name('discogs.authenticate');

Route::get('/release/images', Images::class)->name('release.images');

Route::get('/releases', \App\Http\Controllers\Release\Index::class)->name('releases.index');

Route::get('/release/{id}', Show::class)->name('release.show');

Route::get('/release/{id}/delete', Delete::class)->name('release.delete');

Route::post("/release/{id}/edit", Update::class)->name('release.edit');

Route::group(['prefix' => 'lights', 'middleware' => 'lights'], function () {
    Route::get('/light/{id}/on', \App\Http\Controllers\Lights\TurnOn\Light::class)->name('lights.light.turn-on');
    Route::get('/light/off', Light::class)->name('lights.light.turn-off');
    Route::get('/segments', Segments::class)->name('lights.segments.turn-on');
    Route::get('/strip', Strip::class)->name('lights.strip.turn-on');
    Route::get('/toggle', Toggle::class)->name('lights.toggle');
});

Route::get('/release/{id}/play', Play::class)->name('release.play');








