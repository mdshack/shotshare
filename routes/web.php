<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShotCommentController;
use App\Http\Controllers\ShotController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
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

Route::get('/', FeedController::class)
    ->name('feed')
    ->middleware(['auth', 'verified']);

Route::prefix('shots')
    ->name('shots.')
    ->controller(ShotController::class)
    ->group(function () {
        Route::get('{id}', 'show')->name('show');
        Route::patch('{id}', 'update')->name('update');
        Route::delete('{id}', 'destroy')->name('destroy');

        Route::middleware("feature:comments")
            ->prefix("{shotId}/comments")
            ->name('comments.')
            ->controller(ShotCommentController::class)
            ->group(function() {
                Route::post("", "store")
                    ->name("store")
                    ->middleware("throttle:comment");
            });

        Route::post('{id}/react', 'react')
            ->name('react')
            ->middleware('feature:reactions');
    });

Route::prefix('users')
    ->name('users.')
    ->controller(UserController::class)
    ->group(function() {
        Route::get("{handle}", "show")->name("show");

        Route::middleware("feature:followers")->group(function() {
            Route::post("{handle}/follow", "follow")->name("follow");
            Route::delete("{handle}/unfollow", "unfollow")->name("unfollow");
        });
    });

Route::prefix('api-keys')
    ->name('api-keys.')
    ->controller(ApiKeyController::class)
    ->group(function () {
        Route::post('', 'store')->name('store');
        Route::delete('{id}', 'destroy')->name('destroy');
    });

Route::post('/upload', UploadController::class)
    ->middleware(['auth', 'verified'])
    ->name('upload');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
