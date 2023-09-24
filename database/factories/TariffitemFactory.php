<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tariffitem>
 */
class TariffitemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tariff_id' => $this->faker->numberBetween(1, 3),
            'warehouse_id' => $this->faker->numberBetween(1, 3),
            'product_id' => $this->faker->numberBetween(1, 20),
            'currency_id' => $this->faker->numberBetween(1, 2),
            'price' => $this->faker->randomNumber(2),
        ];
    }
}
