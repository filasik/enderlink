<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page()
    {
    // Ensure tenant exists for path-based tenancy
    \App\Models\Tenant::create(['id' => 'test-tenant']);

        $response = $this->get('/test-tenant/dashboard');
        $response->assertRedirect('/test-tenant/login');
    }

    public function test_authenticated_users_can_visit_the_dashboard()
    {
        // Ensure tenant exists
        \App\Models\Tenant::create(['id' => 'test-tenant']);
    /** @var \App\Models\User $user */
    $user = User::factory()->create(['tenant_id' => 'test-tenant']);
        $this->actingAs($user);

        $response = $this->get('/test-tenant/dashboard');
        $response->assertStatus(200);
    }
}
