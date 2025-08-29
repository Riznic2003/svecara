<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->sentence(15),
            'price' => fake()->randomFloat(2, 0, 9999),
            'unit' => fake()->text(255),
            'sku' => fake()
                ->unique->unique()
                ->ean8(),
            'min_stock' => fake()->dateTime(),
        ];
    }
}
