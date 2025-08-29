<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'email' => fake()
                ->unique()
                ->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'payment_method' => fake()->text(255),
            'status' => fake()->word(),
            'total' => fake()->randomFloat(2, 0, 9999),
        ];
    }
}
