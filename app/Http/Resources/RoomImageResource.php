<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomImageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'room_type_id' => $this->room_type_id,
            'image_path' => $this->image_path,
            'caption' => $this->caption,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}