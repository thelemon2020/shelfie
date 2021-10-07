<?php

use App\Http\Controllers\Add;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CollectionManage;
use App\Http\Controllers\DiscogsController;
use App\Http\Controllers\LoadingPage;
use App\Http\Controllers\Release\Update\Show;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

Route::get('/register', function () {
    return view('register');
})->name('register');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/discogs/callback', [DiscogsController::class, 'callback'])->name('discogs.callback');

Route::get('/collection/build', [CollectionController::class, 'buildCollection'])->name('collection.build');

Route::get('/collection/index', [CollectionController::class, 'showCollection'])->name('collection.index');

Route::get('collection/manage', [CollectionManage::class, 'loadPage'])->name('collection.manage.index');

Route::post('collection/manage/shelf', [CollectionManage::class, 'updateShelfOrder'])->name('collection.manage.shelf');

Route::get('/loadingScreen', LoadingPage::class)->name('loadingScreen');

Route::get('/release/create', Add::class)->name('release.create');

Route::get("/release/{id}/edit", Show::class)->name('release.edit.show');

