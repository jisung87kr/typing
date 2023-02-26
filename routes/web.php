<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SentenceUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SentenceController;

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

Route::get('/', function(){
    return view('home');
})->name('home');

Route::get('/home', function(){
    return view('home');
})->name('home');

Route::get('/rank', [SentenceUserController::class, 'index'])->name('rank');
Route::get('/user', [SentenceUserController::class, 'user'])->name('user');

Route::resource('/sentence-user', SentenceUserController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function(){
        Route::get('/', function(){
           return view('admin.index');
        })->name('index');

        Route::resource('/sentences', SentenceController::class)->except('adminIndex');
        Route::get('/sentences', [SentenceController::class, 'adminIndex'])->name('sentences');
    });