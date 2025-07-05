<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'country',
        'phone',
        'email',
        'rating',
        'amenities',
        'image',
    ];

    protected $casts = [
        'rating' => 'float',
        'amenities' => 'array',
    ];

    // Relationships
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function amenities()
    {
        return $this->hasMany(HotelAmenity::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }
}