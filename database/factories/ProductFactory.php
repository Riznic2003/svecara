<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name'        => 'Sveca ' . $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'price'       => $this->faker->randomFloat(2, 100, 2000),
            'unit'        => 'kom',
            'sku'         => $this->faker->unique()->ean8(),
            'min_stock'   => 0,
        ];
    }
}
