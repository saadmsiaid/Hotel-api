<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\HotelAmenityResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;

use App\Models\HotelAmenity;
use Illuminate\Http\Request;

class HotelAmenityController extends Controller
{
        use AccessAuthorizesRequests;
    public function index()
    {
        return HotelAmenityResource::collection(HotelAmenity::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', HotelAmenity::class);

        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $amenity = HotelAmenity::create($validated);
        return new HotelAmenityResource($amenity);
    }

    public function show(HotelAmenity $hotelAmenity)
    {
        return new HotelAmenityResource($hotelAmenity);
    }

    public function update(Request $request, HotelAmenity $hotelAmenity)
    {
        $this->authorize('update', $hotelAmenity);

        $validated = $request->validate([
            'hotel_id' => 'sometimes|exists:hotels,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $hotelAmenity->update($validated);
        return new HotelAmenityResource($hotelAmenity);
    }

    public function destroy(HotelAmenity $hotelAmenity)
    {
        $this->authorize('delete', $hotelAmenity);
        $hotelAmenity->delete();
        return response()->json(['message' => 'Hotel amenity deleted successfully']);
    }
}