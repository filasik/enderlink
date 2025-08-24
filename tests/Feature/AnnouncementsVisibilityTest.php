<?php

namespace Tests\Feature;

use App\Models\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementsVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_announcements_visible_on_home(): void
    {
        Announcement::factory()->create([
            'tenant_id' => 'tenant1',
            'visibility' => 'public',
            'published_at' => now()->subMinute(),
        ]);
        $response = $this->get('/tenant1');
        $response->assertStatus(200);
    }
}
