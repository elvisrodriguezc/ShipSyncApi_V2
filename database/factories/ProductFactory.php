<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
        $image_name = $this->faker->image('public/storage/images/products', 400, 300, null, false);
        return [
            'company_id' => $this->faker->numberBetween(1, 2),
            'name' => $this->faker->sentence(3),
            'model' => $this->faker->bothify('???####'),
            'category_id' => $this->faker->numberBetween(1, 2),
            'detail' => $this->faker->paragraph,
            'unity_id' => $this->faker->numberBetween(1, 3),
            'currency_id' => 1,
            'price' => $this->faker->randomNumber(2),
            'minimal' => $this->faker->randomNumber(2),
            'brand_id' => $this->faker->numberBetween(1, 2),
            'url' => $this->faker->url,
            'image' => 'products/' . $image_name,
            'set_mode' => $this->faker->lexify('???p'),
            'unspsc_id' => $this->faker->numberBetween(1, 5),
            'taxmode_id' => 1,
        ];
    }
}
