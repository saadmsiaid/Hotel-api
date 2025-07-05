<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\HotelResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
        use AccessAuthorizesRequests;
    public function index()
    {
        return HotelResource::collection(Hotel::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Hotel::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string|email|unique:hotels',
            'rating' => 'nullable|numeric|min:1|max:5',
            'amenities' => 'nullable|array',
            'image' => 'nullable|string',
        ]);

        $hotel = Hotel::create($validated);
        return new HotelResource($hotel);
    }

    public function show(Hotel $hotel)
    {
        return new HotelResource($hotel);
    }

    public function update(Request $request, Hotel $hotel)
    {
        $this->authorize('update', $hotel);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'country' => 'sometimes|string',
            'phone' => 'sometimes|string',
            'email' => 'sometimes|string|email|unique:hotels,email,' . $hotel->id,
            'rating' => 'nullable|numeric|min:1|max:5',
            'amenities' => 'nullable|array',
            'image' => 'nullable|string',
        ]);

        $hotel->update($validated);
        return new HotelResource($hotel);
    }

    public function destroy(Hotel $hotel)
    {
        $this->authorize('delete', $hotel);
        $hotel->delete();
        return response()->json(['message' => 'Hotel deleted successfully']);
    }
}