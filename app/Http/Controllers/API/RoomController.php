<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
        use AccessAuthorizesRequests;
    public function index()
    {
        return RoomResource::collection(Room::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Room::class);

        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms',
            'room_type_id' => 'required|exists:room_types,id',
            'hotel_id' => 'required|exists:hotels,id',
            'status' => 'required|in:available,occupied,maintenance',
            'floor' => 'nullable|integer',
        ]);

        $room = Room::create($validated);
        return new RoomResource($room);
    }

    public function show(Room $room)
    {
        return new RoomResource($room);
    }

    public function update(Request $request, Room $room)
    {
        $this->authorize('update', $room);

        $validated = $request->validate([
            'room_number' => 'sometimes|string|unique:rooms,room_number,' . $room->id,
            'room_type_id' => 'sometimes|exists:room_types,id',
            'hotel_id' => 'sometimes|exists:hotels,id',
            'status' => 'sometimes|in:available,occupied,maintenance',
            'floor' => 'nullable|integer',
        ]);

        $room->update($validated);
        return new RoomResource($room);
    }

    public function destroy(Room $room)
    {
        $this->authorize('delete', $room);
        $room->delete();
        return response()->json(['message' => 'Room deleted successfully']);
    }
}