<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DiscogsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});


Route::get('/login', function (){
    return view('login');
});

Route::get('/logout', function (){
    Session::flush();
    redirect('/');
});

Route::get('/register', function (){
    return view('register');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

Route::get('/index', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('index/discogsauth', [DiscogsController::class, 'authenticate'])->name('discogsauth');

Route::get('/discogs/token', [DiscogsController::class, 'token'])->name('discogs.token');
Route::get('/discogs/callback', [DiscogsController::class, 'callback'])->name('discogs.callback');

Route::get('/collection', [\App\Http\Controllers\CollectionController::class, 'retrieveCollection'])->name('collection.get');
