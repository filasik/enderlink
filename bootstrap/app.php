<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use App\Models\Tenant;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        // Redirect unauthenticated users to tenant-aware login
        $middleware->redirectGuestsTo(function (Request $request) {
            $tenant = $request->route('tenant');

            if (!$tenant) {
                // Try to resolve tenant from the first path segment: /{tenant}/...
                $first = explode('/', trim($request->path(), '/'))[0] ?? null;
                if ($first && Tenant::query()->whereKey($first)->exists()) {
                    $tenant = $first;
                }
            }

            return $tenant ? route('tenant.login', ['tenant' => $tenant]) : route('home');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
