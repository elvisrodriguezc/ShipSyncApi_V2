<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Numerator>
 */
class NumeratorFactory extends Factory
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
            'document_id' => $this->faker->numberBetween(1, 4),
            'serie' => '001',
            'number' => 1,
        ];
    }
}
