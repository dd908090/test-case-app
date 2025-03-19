<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


use App\Http\Controllers\LinkController;

Route::get('/links', [LinkController::class, 'index'])->name('links.index');
Route::get('/links/create', [LinkController::class, 'create'])->name('links.create');
Route::post('/links', [LinkController::class, 'store'])->name('links.store');
Route::get('/links/{link}', [LinkController::class, 'show'])->name('links.show');
Route::get('/links{link}', [LinkController::class, 'edit'])->name('links.edit');
Route::put('/links/{link}', [LinkController::class, 'update'])->name('links.update');
Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');


require __DIR__ . '/auth.php';

Route::get('/{short_link}', [LinkController::class, 'handleRedirect'])->name('links.redirect');
