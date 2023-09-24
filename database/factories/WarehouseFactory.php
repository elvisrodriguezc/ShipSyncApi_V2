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
            'office_id' => $this->faker->numberBetween(1, 2),
            'warehouse_id' => $this->faker->numberBetween(0, 10),
            'detail' => $this->faker->sentence(20),
            'name' => $this->faker->word,
        ];
    }
}
