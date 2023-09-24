<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entity>
 */
class EntityFactory extends Factory
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
            'first_name' => $this->faker->firstNameMale,
            'last_name' => $this->faker->lastName,
            'company_name' => $this->faker->lastName,
            'idform_id' => $this->faker->numberBetween(1, 3),
            'idform_number' => $this->faker->numerify('########'),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail(),
            'ubigeodistrito_id' => $this->faker->numberBetween(1, 25),
            'address' => $this->faker->address,
            'remark' => $this->faker->sentence(4),
        ];
    }
}
