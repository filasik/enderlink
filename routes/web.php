<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DiscordController;
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
    Route::get('/', HomeController::class)->name('tenant.home');
    // Announcements management
    Route::middleware(['auth','verified'])->group(function(){
        Route::get('/setup/announcements', [AnnouncementController::class,'index'])->name('tenant.announcements.index');
        Route::post('/setup/announcements', [AnnouncementController::class,'store'])->name('tenant.announcements.store');
        Route::put('/setup/announcements/{announcement}', [AnnouncementController::class,'update'])->name('tenant.announcements.update');
        Route::delete('/setup/announcements/{announcement}', [AnnouncementController::class,'destroy'])->name('tenant.announcements.destroy');

        Route::get('/setup/pages', [PageController::class,'index'])->name('tenant.pages.index');
        Route::post('/setup/pages', [PageController::class,'store'])->name('tenant.pages.store');
        Route::put('/setup/pages/{page}', [PageController::class,'update'])->name('tenant.pages.update');
        Route::delete('/setup/pages/{page}', [PageController::class,'destroy'])->name('tenant.pages.destroy');
    });

    // Public page display
    Route::get('/p/{page:slug}', [PageController::class,'show'])->name('tenant.pages.show');

    // Discord widget proxy
    Route::get('/api/discord/widget', [DiscordController::class,'widget'])->name('tenant.discord.widget');

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

    // Voting Sites within Setup section (CRUD)
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/setup/vote-sites', [\App\Http\Controllers\VotingSiteController::class, 'index'])
            ->name('tenant.voting.index');
        Route::post('/setup/vote-sites', [\App\Http\Controllers\VotingSiteController::class, 'store'])
            ->name('tenant.voting.store');
        Route::put('/setup/vote-sites/{votingSite}', [\App\Http\Controllers\VotingSiteController::class, 'update'])
            ->name('tenant.voting.update');
        Route::delete('/setup/vote-sites/{votingSite}', [\App\Http\Controllers\VotingSiteController::class, 'destroy'])
            ->name('tenant.voting.destroy');
    });

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

    // Authenticated utility routes inside tenant (logout alias)
    Route::middleware('auth')->group(function(){
        // Provide tenant-prefixed logout route name expected by frontend
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('tenant.logout');
    });

});




