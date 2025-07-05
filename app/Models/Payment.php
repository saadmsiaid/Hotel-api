<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'user_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'payment_date',
    ];

    protected $casts = [
        'amount' => 'float',
        'payment_method' => 'string',
        'status' => 'string',
        'payment_date' => 'datetime',
    ];

    // Relationships
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}