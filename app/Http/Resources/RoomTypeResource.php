<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'capacity' => $this->capacity,
            'base_price' => $this->base_price,
            'amenities' => $this->amenities,
            'hotel_id' => $this->hotel_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}