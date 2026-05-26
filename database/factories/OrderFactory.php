<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total_cents' => 10000,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'is_carbon_neutral_shipping' => true,
        ];
    }
}
