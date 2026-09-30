<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'label' => fake()->words(2, true),
            'short_description' => fake()->sentence(12),
            'description' => fake()->paragraph(),
            'features' => "Feature one\nFeature two",
            'image' => null,
            'icon' => 'fas fa-heartbeat',
            'is_published' => true,
            'display_order' => 0,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn () => ['is_published' => false]);
    }
}
