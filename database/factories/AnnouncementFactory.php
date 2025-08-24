<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        return [
            'tenant_id' => 'tenant1',
            'title' => $this->faker->sentence(4),
            'body' => '<p>'.$this->faker->sentence(10).'</p>',
            'visibility' => 'public',
            'is_pinned' => false,
            'published_at' => now(),
        ];
    }
}
