<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('principal');
})->name('principal')->middleware('guest');

Route::get('/user/{user}', [ProfileController::class, 'show'])->name('user.show')->middleware('auth');

Route::middleware('isAdmin')->group(function () {
    Route::post('/user/{user}/ban', [BanController::class, 'ban'])->name('user.ban')->middleware('auth');
    Route::post('/user/{user}/unban', [BanController::class, 'unban'])->name('user.unban')->middleware('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/lang', [ProfileController::class, 'changeLang'])->name('profile.changeLang');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.changeAvatar');
});

require __DIR__.'/auth.php';
