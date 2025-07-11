<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $hotels = Hotel::all();
        return view('hotels.index', compact('hotels'));
    }

    public function show(Hotel $hotel)
    {
        return view('hotels.show', compact('hotel'));
    }

    public function create()
    {
        $this->authorize('create', Hotel::class);
        return view('admin.hotels.create');
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
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|string',
        ]);

        Hotel::create($validated);
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel created successfully!');
    }

    public function edit(Hotel $hotel)
    {
        $this->authorize('update', $hotel);
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $this->authorize('update', $hotel);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|string',
        ]);

        $hotel->update($validated);
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel updated successfully!');
    }

    public function destroy(Hotel $hotel)
    {
        $this->authorize('delete', $hotel);
        $hotel->delete();
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted successfully!');
    }
}