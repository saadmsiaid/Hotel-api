<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'room_id' => $this->room_id,
            'hotel_id' => $this->hotel_id,
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'guests' => $this->guests,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'special_requests' => $this->special_requests,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}