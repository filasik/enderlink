<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_page_route_returns_200(): void
    {
        $page = Page::factory()->create([
            'tenant_id' => 'tenant1',
            'is_published' => true,
        ]);
        $this->get('/tenant1/p/'.$page->slug)->assertStatus(200);
    }
}
