<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $tenant = Auth::user()?->tenant_id;
        if (Auth::user()?->hasVerifiedEmail()) {
            return redirect()->intended(route('tenant.dashboard', ['tenant' => $tenant], false).'?verified=1');
        }

        $request->fulfill();

        $tenant = $tenant ?? Auth::user()?->tenant_id;
        return redirect()->intended(route('tenant.dashboard', ['tenant' => $tenant], false).'?verified=1');
    }
}
