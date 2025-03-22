<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'headquarter_id' => 1,
            'warehouse_id' => 1,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'username' => fake()->unique()->userName(),
            'role_id' => fake()->randomElement([1, 2, 3, 4]),
            'document_id' => 1,
            'document_number' => fake()->unique()->numerify('########'),

            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'license' => fake()->numerify('##########'),
            'licencecategory' => fake()->randomElement(['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10']),
            'isAF' => fake()->randomElement([0, 1]),
            'isAFP' => fake()->randomElement([0, 1]),
            'payrollafp_id' => 1,
            'salary' => fake()->randomFloat(2, 1000, 5000),
            'additionalpay' => fake()->randomFloat(2, 100, 500),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
