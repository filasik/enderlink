<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

        $response = $this
            ->actingAs($user)
            ->from('/test-tenant/settings/password')
            ->put('/test-tenant/settings/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/test-tenant/settings/password');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

        $response = $this
            ->actingAs($user)
            ->from('/test-tenant/settings/password')
            ->put('/test-tenant/settings/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrors('current_password')
            ->assertRedirect('/test-tenant/settings/password');
    }
}
