<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
        use AccessAuthorizesRequests;
    public function index()
    {
        return ReservationResource::collection(Reservation::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Reservation::class);

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'hotel_id' => 'required|exists:hotels,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'special_requests' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        $reservation = Reservation::create($validated);
        return new ReservationResource($reservation);
    }

    public function show(Reservation $reservation)
    {
        return new ReservationResource($reservation);
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
        return new ReservationResource($reservation);
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}