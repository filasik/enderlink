<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        return [
            'tenant_id' => 'tenant1',
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::random(5),
            'content' => '<p>'.$this->faker->paragraph().'</p>',
            'is_published' => true,
            'published_at' => now(),
            'meta_description' => $this->faker->sentence(8),
        ];
    }
}
