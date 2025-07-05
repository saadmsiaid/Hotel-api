<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        $checkIn = $this->faker->dateTimeBetween('now', '+1 month');
        $checkOut = $this->faker->dateTimeBetween($checkIn, $checkIn->format('Y-m-d') . ' +7 days');

        return [
            'user_id' => User::factory(),
            'room_id' => Room::factory(),
            'hotel_id' => Hotel::factory(),
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'guests' => $this->faker->numberBetween(1, 4),
            'total_price' => $this->faker->randomFloat(2, 100, 2000),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'special_requests' => $this->faker->optional()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}