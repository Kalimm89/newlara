<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategorySingleController;
use App\Http\Controllers\TagSingleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscribeController;


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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/article/{slug}', [HomeController::class, 'show'])->name('homes.single');
Route::get('/category/{slug}', [CategorySingleController::class, 'show'])->name('categories.single');
Route::get('/tag/{slug}', [TagSingleController::class, 'show'])->name('tags.single');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/subscribe', [SubscribeController::class, 'store'])->name('subscribe');


Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('admin.index');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/tags', TagController::class);
    Route::resource('/posts', PostController::class);
});

Route::middleware('guest')->group(function () {

    Route::get('/register', [UserController::class, 'create'])->name('register.create');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');
    Route::get('/login', [UserController::class, 'loginForm'])->name('login.create');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');
