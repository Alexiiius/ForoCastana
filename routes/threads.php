<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;


// Vista principal de todos los hilos
Route::get('/main', [ThreadController::class, 'main'])->middleware(['auth'])->name('main');

// Vista de hilo seleccionado segun su id
Route::get('/thread/{id}', [ThreadController::class, 'show'])->name('thread.show')->middleware(['auth']);

// Acciones de hilo
Route::middleware(['auth'])->prefix('thread/{thread}')->group(function () {
    Route::post('/close', [ThreadController::class, 'close'])->name('thread.close');
    Route::post('/open', [ThreadController::class, 'open'])->name('thread.open');
    Route::post('/delete', [ThreadController::class, 'delete'])->name('thread.delete');
    Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
});

Route::middleware(['auth'])->group(function () {
    Route::delete('/comments/{comment}', [CommentController::class, 'delete'])->name('comment.delete');
    Route::post('/thread/store', [ThreadController::class, 'store'])->name('thread.store');
});

require __DIR__.'/auth.php';
