<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    $response = $this->get('/test-tenant/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

    $response = $this->post('/test-tenant/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    $response->assertRedirect('/test-tenant/dashboard');
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

    $this->post('/test-tenant/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

    $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    $response->assertRedirect('/test-tenant');
    }
}
