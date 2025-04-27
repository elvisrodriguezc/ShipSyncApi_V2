<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => 1,
            'name' => $this->faker->unique()->word(),
            'symbol' => $this->faker->unique()->randomElement(['kg', 'lb', 'oz', 'g', 'l', 'ml', 'cm', 'm', 'km', 'in', 'und']),
            'value' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
