<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

/**
 * @method Authenticatable|null user()
 */
class ReviewController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        /** @var Authenticatable|null $user */
        $user = auth()->user();
        $reviews = $user ? Review::where('user_id', $user->id)->get() : collect([]);
        return view('reviews.index', compact('reviews'));
    }

    public function create()
    {
        $hotels = \App\Models\Hotel::all();
        $reservations = \App\Models\Reservation::all();
        return view('reviews.create', compact('hotels', 'reservations'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Review::class);

        /** @var Authenticatable|null $user */
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Please log in.']);
        }

        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'reservation_id' => 'required|exists:reservations,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';

        Review::create($validated);
        return redirect()->route('reviews.index')->with('success', 'Review submitted successfully!');
    }

    public function edit(Review $review)
    {
        $this->authorize('update', $review);
        $hotels = \App\Models\Hotel::all();
        $reservations = \App\Models\Reservation::all();
        return view('reviews.edit', compact('review', 'hotels', 'reservations'));
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'status' => 'sometimes|in:pending,approved,rejected',
        ]);

        $review->update($validated);
        return redirect()->route('reviews.index')->with('success', 'Review updated successfully!');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully!');
    }
}