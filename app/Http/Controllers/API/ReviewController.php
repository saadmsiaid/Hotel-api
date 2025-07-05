<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
        use AccessAuthorizesRequests;
    public function index()
    {
        return ReviewResource::collection(Review::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Review::class);

        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'reservation_id' => 'required|exists:reservations,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        $review = Review::create($validated);
        return new ReviewResource($review);
    }

    public function show(Review $review)
    {
        return new ReviewResource($review);
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
        return new ReviewResource($review);
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();
        return response()->json(['message' => 'Review deleted successfully']);
    }
}