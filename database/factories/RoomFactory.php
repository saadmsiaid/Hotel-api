<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'room_number' => $this->faker->unique()->numberBetween(100, 999),
            'room_type_id' => RoomType::factory(),
            'hotel_id' => Hotel::factory(),
            'status' => $this->faker->randomElement(['available', 'occupied', 'maintenance']),
            'floor' => $this->faker->numberBetween(1, 20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}