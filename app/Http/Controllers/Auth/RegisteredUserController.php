<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            // Ensure the chosen tenant id isn't already taken by another tenant
            'tenant_id' => 'required|string|max:50|unique:tenants,id',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Tenant::create([
            'id' => $request->tenant_id,
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'tenant_id' => $request->tenant_id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return to_route('tenant.dashboard', ['tenant' => $request->tenant_id]);
    }
}
