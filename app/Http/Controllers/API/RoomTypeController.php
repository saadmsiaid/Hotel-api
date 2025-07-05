<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomTypeResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
        use AccessAuthorizesRequests;
    public function index()
    {
        return RoomTypeResource::collection(RoomType::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', RoomType::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'base_price' => 'required|numeric|min:0',
            'amenities' => 'nullable|array',
            'hotel_id' => 'required|exists:hotels,id',
        ]);

        $roomType = RoomType::create($validated);
        return new RoomTypeResource($roomType);
    }

    public function show(RoomType $roomType)
    {
        return new RoomTypeResource($roomType);
    }

    public function update(Request $request, RoomType $roomType)
    {
        $this->authorize('update', $roomType);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'sometimes|integer|min:1',
            'base_price' => 'sometimes|numeric|min:0',
            'amenities' => 'nullable|array',
            'hotel_id' => 'sometimes|exists:hotels,id',
        ]);

        $roomType->update($validated);
        return new RoomTypeResource($roomType);
    }

    public function destroy(RoomType $roomType)
    {
        $this->authorize('delete', $roomType);
        $roomType->delete();
        return response()->json(['message' => 'Room type deleted successfully']);
    }
}