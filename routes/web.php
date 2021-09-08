<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CollectionManage;
use App\Http\Controllers\DiscogsController;
use App\Http\Controllers\Release\Update\Show;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoadingPage;
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

Route::get('/register', function (){
    if (User::all()->first())
    {
        return route('home');
    }
    return view('register');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/discogs/callback', [DiscogsController::class, 'callback'])->name('discogs.callback');

Route::get('/collection/build', [CollectionController::class, 'buildCollection'])->name('collection.build');

Route::get('/collection/index',[CollectionController::class, 'showCollection'])->name('collection.index');

Route::get('collection/manage', [CollectionManage::class, 'loadPage'])->name('collection.manage.index');

Route::post('collection/manage/shelf', [CollectionManage::class, 'updateShelfOrder'])->name('collection.manage.shelf');

Route::get('/loadingScreen', LoadingPage::class)->name('loadingScreen');

Route::get("/release/{id}/edit",Show::class)->name('release.edit.show');