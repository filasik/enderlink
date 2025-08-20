<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

        $response = $this
            ->actingAs($user)
            ->get('/test-tenant/settings/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

        $response = $this
            ->actingAs($user)
            ->patch('/test-tenant/settings/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/test-tenant/settings/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

        $response = $this
            ->actingAs($user)
            ->patch('/test-tenant/settings/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/test-tenant/settings/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

        $response = $this
            ->actingAs($user)
            ->delete('/test-tenant/settings/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/test-tenant');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);

        $response = $this
            ->actingAs($user)
            ->from('/test-tenant/settings/profile')
            ->delete('/test-tenant/settings/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect('/test-tenant/settings/profile');

        $this->assertNotNull($user->fresh());
    }
}
