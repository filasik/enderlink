<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/setup', [SettingsController::class, 'index'])->name('setup.index');
Route::post('/setup', [SettingsController::class, 'store'])->name('setup.store');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
