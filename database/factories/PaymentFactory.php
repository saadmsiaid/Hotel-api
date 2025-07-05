<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(),
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 2000),
            'payment_method' => $this->faker->randomElement(['credit_card', 'debit_card', 'paypal', 'bank_transfer']),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'transaction_id' => $this->faker->uuid(),
            'payment_date' => $this->faker->dateTimeThisMonth(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}