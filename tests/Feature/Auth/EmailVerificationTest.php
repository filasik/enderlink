<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    $user = User::factory()->unverified()->create(['tenant_id' => 'test-tenant']);

    $response = $this->actingAs($user)->get('/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    $user = User::factory()->unverified()->create(['tenant_id' => 'test-tenant']);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    $response->assertRedirect('/test-tenant/dashboard?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash()
    {
    \App\Models\Tenant::create(['id' => 'test-tenant']);
    $user = User::factory()->unverified()->create(['tenant_id' => 'test-tenant']);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
