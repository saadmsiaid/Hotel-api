<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Hotel;
use App\Models\HotelAmenity;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create users
        User::factory(10)->create();

        // Create hotels
        Hotel::factory(5)->create()->each(function ($hotel) {
            // Create admins for each hotel
            Admin::factory(2)->create(['hotel_id' => $hotel->id]);

            // Create room types for each hotel
            RoomType::factory(3)->create(['hotel_id' => $hotel->id])->each(function ($roomType) {
                // Create rooms for each room type
                Room::factory(5)->create([
                    'room_type_id' => $roomType->id,
                    'hotel_id' => $roomType->hotel_id,
                ]);

                // Create room images
                RoomImage::factory(2)->create(['room_type_id' => $roomType->id]);
            });

            // Create hotel amenities
            HotelAmenity::factory(3)->create(['hotel_id' => $hotel->id]);

            // Create promotions
            Promotion::factory(2)->create(['hotel_id' => $hotel->id]);

            // Create reservations
            Reservation::factory(10)->create(['hotel_id' => $hotel->id])->each(function ($reservation) {
                // Create payments for each reservation
                Payment::factory(1)->create([
                    'reservation_id' => $reservation->id,
                    'user_id' => $reservation->user_id,
                ]);

                // Create reviews for each reservation
                Review::factory(1)->create([
                    'reservation_id' => $reservation->id,
                    'user_id' => $reservation->user_id,
                    'hotel_id' => $reservation->hotel_id,
                ]);
            });
        });
    }
}