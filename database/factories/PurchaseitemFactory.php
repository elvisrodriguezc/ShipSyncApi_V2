<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchaseitem>
 */
class PurchaseitemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchase_id' => $this->faker->numberBetween(1, 4),
            'product_id' => $this->faker->numberBetween(1, 10),
            'unity_id' => $this->faker->numberBetween(1, 3),
            'price' => $this->faker->numberBetween(1, 150),
            'quantity' => $this->faker->numberBetween(1, 10),
            'discount' => $this->faker->numberBetween(1, 10),
            'discount_percent' => 0,
            'status' => $this->faker->numberBetween(0, 1),
        ];
    }
}
