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
            'user_id'        => null,
            'full_name'      => $this->faker->name(),
            'email'          => $this->faker->safeEmail(),
            'phone'          => $this->faker->phoneNumber(),
            'address'        => $this->faker->address(),
            'payment_method' => 'pouzećem',
            'status'         => 'primljena',
            'total'          => 0,
        ];
    }
}
