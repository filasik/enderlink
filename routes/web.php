<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
*/
Route::middleware([
    'web',
    'auth',
    'verified',
    InitializeTenancyByPath::class,
    //PreventAccessFromCentralDomains::class,
])->prefix('/{tenant}')->group(function () {
    // Tenant dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/setup', [SettingsController::class, 'index'])->name('setup.index');
    Route::post('/setup', [SettingsController::class, 'store'])->name('setup.store');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
