<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Single', 'Double', 'Suite', 'Deluxe', 'Family']),
            'description' => $this->faker->sentence(),
            'capacity' => $this->faker->numberBetween(1, 6),
            'base_price' => $this->faker->randomFloat(2, 50, 500),
            'amenities' => json_encode([
                $this->faker->randomElement(['tv', 'minibar', 'balcony', 'air_conditioning', 'wifi']),
                $this->faker->randomElement(['tv', 'minibar', 'balcony', 'air_conditioning', 'wifi']),
            ]),
            'hotel_id' => Hotel::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}