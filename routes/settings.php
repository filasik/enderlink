<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('tenant.profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('tenant.profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('tenant.profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('tenant.password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('tenant.password.update');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('tenant.appearance');
});
