<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
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
            'warehouse_id' => $this->faker->numberBetween(1, 5),
            'entity_id' => $this->faker->numberBetween(1, 4),
            'receipttype_id' => $this->faker->numberBetween(1, 3),
            'document_serial' => $this->faker->bothify('??####'),
            'document_number' => $this->faker->bothify('00#####'),
            'guide_number' => $this->faker->bothify('??####-00#####'),
            'credit' => $this->faker->numberBetween(0, 1),
            'date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'duedate' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
