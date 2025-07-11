<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

/**
 * @method Authenticatable|null user()
 */
class ReservationController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        /** @var Authenticatable|null $user */
        $user = auth()->user();
        $reservations = $user ? Reservation::where('user_id', $user->id)->get() : collect([]);
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $hotels = \App\Models\Hotel::all();
        $rooms = \App\Models\Room::all();
        return view('reservations.create', compact('hotels', 'rooms'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Reservation::class);

        /** @var Authenticatable|null $user */
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Please log in.']);
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'hotel_id' => 'required|exists:hotels,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'special_requests' => 'nullable|string',
        ]);

        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';

        Reservation::create($validated);
        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully!');
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $this->authorize('update', $reservation);
        $hotels = \App\Models\Hotel::all();
        $rooms = \App\Models\Room::all();
        return view('reservations.edit', compact('reservation', 'hotels', 'rooms'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $validated = $request->validate([
            'room_id' => 'sometimes|exists:rooms,id',
            'hotel_id' => 'sometimes|exists:hotels,id',
            'check_in_date' => 'sometimes|date|after_or_equal:today',
            'check_out_date' => 'sometimes|date|after:check_in_date',
            'guests' => 'sometimes|integer|min:1',
            'total_price' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:pending,confirmed,cancelled,completed',
            'special_requests' => 'nullable|string',
        ]);

        $reservation->update($validated);
        return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully!');
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully!');
    }
}