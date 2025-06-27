<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
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



require __DIR__.'/auth.php';
/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',
    InitializeTenancyByPath::class,
    //PreventAccessFromCentralDomains::class,
])->prefix('/{tenant}')->group(function () {
    // Vždy Welcome, i když přihlášený nebo nepřihlášený
    Route::get('/', function () {
        return Inertia::render('Welcome');
    })->name('tenant.home');

    // Dashboard jen pro přihlášené
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('tenant.dashboard');

    // Setup jen pro přihlášené
    Route::get('/setup/general', [SettingsController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('tenant.setup.index');
    Route::post('/setup', [SettingsController::class, 'store'])
        ->middleware(['auth', 'verified'])
        ->name('tenant.setup.store');

    // Guest routes (login, register, password reset)
    Route::middleware(['guest'])->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('tenant.register');
        Route::post('register', [RegisteredUserController::class, 'store'])
            ->name('tenant.register.store');
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('tenant.login');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])
            ->name('tenant.login.store');
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('tenant.password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('tenant.password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('tenant.password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('tenant.password.store');
    });

    require __DIR__.'/settings.php';

});




