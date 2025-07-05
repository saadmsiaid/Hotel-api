<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Hotel',
            'description' => $this->faker->paragraph(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->companyEmail(),
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'amenities' => json_encode([
                $this->faker->randomElement(['wifi', 'pool', 'parking', 'gym', 'spa', 'restaurant']),
                $this->faker->randomElement(['wifi', 'pool', 'parking', 'gym', 'spa', 'restaurant']),
            ]),
            'image' => $this->faker->imageUrl(640, 480, 'hotels'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}