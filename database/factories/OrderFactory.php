<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'user_id' => $this->faker->numberBetween(1, 3),
            'entity_id' => $this->faker->numberBetween(1, 2),
            'cashier_id' => $this->faker->numberBetween(1, 2),
            'currency_id' => $this->faker->numberBetween(1, 2),
            'table_id' => $this->faker->numberBetween(1, 5),
            'tariff_id' => $this->faker->numberBetween(1, 3),
            'number' => $this->faker->numerify('######'),
            'pax' => $this->faker->numberBetween(1, 6),
        ];
    }
}
