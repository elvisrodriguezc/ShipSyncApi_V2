<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unity>
 */
class UnityFactory extends Factory
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
            'name' => $this->faker->sentence(1),
            'abbreviation' => $this->faker->regexify('[A-Za-z0-9]{2}'),
            'value' =>  $this->faker->numberBetween(1, 10),
        ];
    }
}
