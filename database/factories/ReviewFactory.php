<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'hotel_id' => Hotel::factory(),
            'reservation_id' => Reservation::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->optional()->paragraph(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}