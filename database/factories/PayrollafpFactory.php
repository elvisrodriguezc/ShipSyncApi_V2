<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payrollafp>
 */
class PayrollafpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'contribution' => $this->faker->randomFloat(2, 0, 99.99),
            'comission' => $this->faker->randomFloat(2, 0, 99.99),
            'profit' => $this->faker->randomFloat(2, 0, 99.99),
        ];
    }
}
