<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Models\Shot;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/shots/{id}', function (string $id) {
    return Inertia::render('Shots/Show', [
        'shot' => fn () => Shot::whereId($id)->firstOrFail()
    ]);
})->name('shots.show');

Route::post('/upload', UploadController::class)->middleware(['auth', 'verified'])->name('upload');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
