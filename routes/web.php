<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShotController;
use App\Http\Controllers\UploadController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// TODO: ability to configure homepage (discover or upload)
Route::get('/', [UploadController::class, 'create'])->name('home');

Route::prefix("uploads")
    ->name("uploads.")
    ->controller(UploadController::class)
    ->group(function() {
        Route::get("", "create");
        // TODO: support guest uploads?
        Route::post("", "store")->middleware(['auth', 'verified']);
    });

Route::prefix("discover")
    ->name("discover.")
    ->controller(DiscoverController::class)
    ->group(function() {

    });

Route::prefix('shots')
    ->name('shots.')
    ->controller(ShotController::class)
    ->group(function () {
        Route::get('', 'index')
            ->middleware(['auth', 'verified'])
            ->name('index');
        Route::get('{id}', 'show')->name('show');
        Route::patch('{id}', 'update')->name('update');
        Route::delete('{id}', 'destroy')->name('destroy');

        Route::post('{id}/react', 'react')
            ->name('react')
            ->middleware('feature:reactions');

        Route::post('{id}/favorite', 'favorite')
            ->name('favorite')
            ->middleware('feature:favorites');
        Route::delete('{id}/favorite', 'unfavorite')
            ->name('unfavorite')
            ->middleware('feature:favorites');
    });

Route::prefix('api-keys')
    ->name('api-keys.')
    ->controller(ApiKeyController::class)
    ->group(function () {
        Route::post('', 'store')->name('store');
        Route::delete('{id}', 'destroy')->name('destroy');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');
    Route::delete('/profile/avatar', [ProfileController::class, 'destroyAvatar'])->name('profile.avatar.destroy');
});

require __DIR__.'/auth.php';
