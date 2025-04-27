<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => fake()->numberBetween(1, 2),
            'category_id' => fake()->numberBetween(1, 6),
            'name' => fake()->words(3, true),
            'description' => fake()->text(),
            'image' => 'product.png',
            'unit_id' => fake()->numberBetween(1, 5),
            'price' => fake()->randomFloat(2, 1, 1000),
            'stock' => fake()->numberBetween(1, 100),
            'status' => 1,
        ];
    }
}
