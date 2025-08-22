<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

    $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

    $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
