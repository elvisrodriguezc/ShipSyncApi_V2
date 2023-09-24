<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $width = 800;
        $height = 400;
        return [
            'company_id' => 1,
            'name' => $this->faker->sentence(1),
            'image' => $this->faker->imageUrl($width, $height, 'cats', true, 'Faker'),
        ];
    }
}
