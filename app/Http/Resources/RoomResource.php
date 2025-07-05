<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'room_number' => $this->room_number,
            'room_type_id' => $this->room_type_id,
            'hotel_id' => $this->hotel_id,
            'status' => $this->status,
            'floor' => $this->floor,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}