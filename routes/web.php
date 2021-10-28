<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('like/{post}', [PostController::class, 'like'])->name('like');
Route::post('comment/{post}', [PostController::class, 'storeComment'])->name('posts.store_comment');
Route::resource('posts', PostController::class);


require __DIR__.'/auth.php';
