<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'name' => fake()->word(),
            'description' => fake()->text(),
            'slug' => fake()->unique()->slug(),
            'image' => 'category.png',
            'status' => 1,
        ];
    }
}
