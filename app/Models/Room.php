<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type_id',
        'hotel_id',
        'status',
        'floor',
    ];

    protected $casts = [
        'status' => 'string',
        'floor' => 'integer',
    ];

    // Relationships
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}