<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $width = 100;
        $height = 100;
        return [
            'name' => $this->faker->company,
            'ruc' => $this->faker->numerify('20#########'),
            'address' => $this->faker->address,
            'phone' => $this->faker->numerify('084-######'),
            'email' => $this->faker->email,
            'logo' => $this->faker->imageUrl($width, $height, 'cats'),
            'web' => $this->faker->url,
            'description' => $this->faker->bs,
            'status' => $this->faker->numberBetween(1, 1),
        ];
    }
}
