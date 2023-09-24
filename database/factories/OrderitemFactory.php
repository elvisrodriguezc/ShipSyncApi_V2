<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orderitem>
 */
class OrderitemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => $this->faker->numberBetween(1, 2),
            'tariffitem_id' => $this->faker->numberBetween(1, 20),
            'quantity' => $this->faker->randomNumber(4),
            'price' => $this->faker->randomNumber(2),
            'discount' => $this->faker->randomNumber(2),
            'discount_percent' => 0,
            'description' => $this->faker->sentence,
        ];
    }
}
