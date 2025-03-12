<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'headquarter_id' => $this->faker->numberBetween(1, 4),
            'name' => $this->faker->name,
            'description' => $this->faker->text(100),
            'mode' => 'P'
        ];
    }
}
