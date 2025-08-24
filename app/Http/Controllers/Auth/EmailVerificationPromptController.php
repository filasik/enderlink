<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Show the email verification prompt page.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        $tenant = Auth::user()?->tenant_id;

        if ($tenant) {
            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->intended(route('tenant.dashboard', ['tenant' => $tenant]));
            } 

            return Inertia::render('auth/VerifyEmail', ['status' => $request->session()->get('status')]);
        }

        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : Inertia::render('auth/VerifyEmail', ['status' => $request->session()->get('status')]);
    }
}
