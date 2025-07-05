<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d') . ' +30 days');

        return [
            'hotel_id' => Hotel::factory(),
            'code' => $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->optional()->sentence(),
            'discount_percentage' => $this->faker->optional()->randomFloat(2, 5, 50),
            'discount_amount' => $this->faker->optional()->randomFloat(2, 10, 100),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => $this->faker->boolean(80),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}