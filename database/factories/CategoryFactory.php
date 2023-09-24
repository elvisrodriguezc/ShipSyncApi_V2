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
            'company_id' => $this->faker->numberBetween(1, 2),
            // 'company_id' => Company::factory(),
            'text' => $this->faker->sentence(1),
            'icon' => $this->faker->url,
            'description' => $this->faker->sentence(2),
            'price_rate' => 10,
            'status' => 1,
        ];
    }
}
