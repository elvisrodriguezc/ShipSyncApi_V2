<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => 1,
            'entity_id' => 1,
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'plate' => strtoupper($this->faker->regexify('[A-Z]{2}[0-9]{4}')),
            'color' => $this->faker->colorName,
            'model' => $this->faker->word,
            'year' => $this->faker->year,
            'chassis' => $this->faker->word,
            'tuc' => $this->faker->word,
            'image' => $this->faker->imageUrl,
            'status' => 1,
        ];
    }
}
