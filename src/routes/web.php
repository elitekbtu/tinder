<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\SwipeController;
use App\Http\Controllers\MemeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MatchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Главная страница (редирект на свайпы или welcome)
Route::get('/', function () {
    return auth()->check() ? redirect()->route('swipe.index') : view('welcome');
});

// Dashboard страница
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Группа маршрутов, доступных только авторизованным пользователям
Route::middleware('auth')->group(function () {
    // Профиль пользователя (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Статистика
    Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');

    // Свайпы
    Route::prefix('swipe')->group(function () {
        Route::get('/', [SwipeController::class, 'index'])->name('swipe.index');
        Route::post('/{meme}', [SwipeController::class, 'store'])->name('swipe.store');
        Route::get('/history', [SwipeController::class, 'history'])->name('swipe.history');
        Route::delete('/clear-history', [SwipeController::class, 'clearHistory'])->name('swipe.clear-history');
    });

    // Избранное
    Route::prefix('favorites')->group(function () {
        Route::get('/', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::delete('/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    });

    // Совпадения
    Route::prefix('matches')->group(function () {
        Route::get('/', [MatchController::class, 'index'])->name('matches.index');
        Route::get('/check', [MatchController::class, 'check'])->name('matches.check');
    });

    // Мемы (полный ресурсный маршрут)
    Route::resource('memes', MemeController::class)->except(['edit', 'update']);
});

// Маршруты аутентификации (Laravel Breeze)
require __DIR__.'/auth.php';
