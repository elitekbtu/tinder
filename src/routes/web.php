<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\SwipeController;
use App\Http\Controllers\MemeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MatchController;


Route::get('/', function () {
    return auth()->check() ? redirect()->route('swipe.index') : view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');

    Route::prefix('swipe')->group(function () {
        Route::get('/', [SwipeController::class, 'index'])->name('swipe.index');
        Route::post('/{meme}', [SwipeController::class, 'store'])->name('swipe.store');
        Route::get('/history', [SwipeController::class, 'history'])->name('swipe.history');
        Route::delete('/clear-history', [SwipeController::class, 'clearHistory'])->name('swipe.clear-history');
    });


    Route::prefix('favorites')->group(function () {
        Route::get('/', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::delete('/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    });

    Route::prefix('matches')->group(function () {
        Route::get('/', [MatchController::class, 'index'])->name('matches.index');
        Route::get('/check', [MatchController::class, 'check'])->name('matches.check');
    });

    Route::resource('memes', MemeController::class)->except(['edit', 'update']);
});

require __DIR__.'/auth.php';
