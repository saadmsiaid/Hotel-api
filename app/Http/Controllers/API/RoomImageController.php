<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomImageResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;

use App\Models\RoomImage;
use Illuminate\Http\Request;

class RoomImageController extends Controller
{
        use AccessAuthorizesRequests;
    public function index()
    {
        return RoomImageResource::collection(RoomImage::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', RoomImage::class);

        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'image_path' => 'required|string',
            'caption' => 'nullable|string',
        ]);

        $roomImage = RoomImage::create($validated);
        return new RoomImageResource($roomImage);
    }

    public function show(RoomImage $roomImage)
    {
        return new RoomImageResource($roomImage);
    }

    public function update(Request $request, RoomImage $roomImage)
    {
        $this->authorize('update', $roomImage);

        $validated = $request->validate([
            'room_type_id' => 'sometimes|exists:room_types,id',
            'image_path' => 'sometimes|string',
            'caption' => 'nullable|string',
        ]);

        $roomImage->update($validated);
        return new RoomImageResource($roomImage);
    }

    public function destroy(RoomImage $roomImage)
    {
        $this->authorize('delete', $roomImage);
        $roomImage->delete();
        return response()->json(['message' => 'Room image deleted successfully']);
    }
}