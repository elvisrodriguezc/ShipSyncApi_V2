<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ubigeodistrito>
 */
class UbigeodistritoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ubigeoprovincia_id' => $this->faker->numberBetween(1, 20),
            'name' => $this->faker->state,
            'code' => 'XX',
            'ubigeo' => 'XXXXXX',
        ];
    }
}
