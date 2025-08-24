<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use App\Models\VotingSite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VotingSitesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Tenant::create(['id' => 'test-tenant']);
    }

    public function test_authenticated_user_can_create_voting_site()
    {
        $user = User::factory()->create(['tenant_id' => 'test-tenant']);
        $this->actingAs($user);

    $response = $this->post('/test-tenant/setup/vote-sites', [
            'name' => 'TopG',
            'url_template' => 'https://topg.org/minecraft/servers/{username}',
            'pass_username' => true,
            'enabled' => true,
        ]);

    $response->assertRedirect('/test-tenant/setup/vote-sites');
        $this->assertDatabaseHas('voting_sites', [
            'name' => 'TopG',
            'pass_username' => 1,
        ]);
    }

    public function test_update_voting_site()
    {
        $user = User::factory()->create(['tenant_id' => 'test-tenant']);
        $this->actingAs($user);
        $site = VotingSite::create([
            'tenant_id' => 'test-tenant',
            'name' => 'Site1',
            'url_template' => 'https://example.com/vote',
            'pass_username' => false,
            'enabled' => true,
            'sort_order' => 0,
        ]);

    $response = $this->put('/test-tenant/setup/vote-sites/'.$site->id, [
            'name' => 'Site1 Updated',
            'url_template' => 'https://example.com/vote?u={username}',
            'pass_username' => true,
            'enabled' => false,
            'sort_order' => 2,
        ]);
    $response->assertRedirect('/test-tenant/setup/vote-sites');
        $this->assertDatabaseHas('voting_sites', [
            'id' => $site->id,
            'name' => 'Site1 Updated',
            'pass_username' => 1,
            'enabled' => 0,
            'sort_order' => 2,
        ]);
    }

    public function test_delete_voting_site()
    {
        $user = User::factory()->create(['tenant_id' => 'test-tenant']);
        $this->actingAs($user);
        $site = VotingSite::create([
            'tenant_id' => 'test-tenant',
            'name' => 'Site2',
            'url_template' => 'https://example.org/vote',
            'pass_username' => false,
            'enabled' => true,
            'sort_order' => 0,
        ]);

    $response = $this->delete('/test-tenant/setup/vote-sites/'.$site->id);
    $response->assertRedirect('/test-tenant/setup/vote-sites');
        $this->assertDatabaseMissing('voting_sites', [ 'id' => $site->id ]);
    }

    public function test_toggle_pass_username()
    {
        $user = User::factory()->create(['tenant_id' => 'test-tenant']);
        $this->actingAs($user);
        $site = VotingSite::create([
            'tenant_id' => 'test-tenant',
            'name' => 'ToggleSite',
            'url_template' => 'https://example.net/vote?u={username}',
            'pass_username' => true,
            'enabled' => true,
            'sort_order' => 0,
        ]);

        // Toggle off
        $response = $this->put('/test-tenant/setup/vote-sites/'.$site->id, [
            'name' => 'ToggleSite',
            'url_template' => 'https://example.net/vote?u={username}',
            'pass_username' => false,
            'enabled' => true,
            'sort_order' => 0,
        ]);
        $response->assertRedirect('/test-tenant/setup/vote-sites');
        $this->assertDatabaseHas('voting_sites', [ 'id' => $site->id, 'pass_username' => 0 ]);

        // Toggle on again
        $response = $this->put('/test-tenant/setup/vote-sites/'.$site->id, [
            'name' => 'ToggleSite',
            'url_template' => 'https://example.net/vote?u={username}',
            'pass_username' => true,
            'enabled' => true,
            'sort_order' => 0,
        ]);
        $response->assertRedirect('/test-tenant/setup/vote-sites');
        $this->assertDatabaseHas('voting_sites', [ 'id' => $site->id, 'pass_username' => 1 ]);
    }
}
