<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;

use Illuminate\Http\Request;

class PromotionController extends Controller
{
        use AccessAuthorizesRequests;
    public function index()
    {
        return PromotionResource::collection(Promotion::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Promotion::class);

        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'code' => 'required|string|unique:promotions',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        $promotion = Promotion::create($validated);
        return new PromotionResource($promotion);
    }

    public function show(Promotion $promotion)
    {
        return new PromotionResource($promotion);
    }

    public function update(Request $request, Promotion $promotion)
    {
        $this->authorize('update', $promotion);

        $validated = $request->validate([
            'hotel_id' => 'sometimes|exists:hotels,id',
            'code' => 'sometimes|string|unique:promotions,code,' . $promotion->id,
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'sometimes|date|after_or_equal:today',
            'end_date' => 'sometimes|date|after:start_date',
            'is_active' => 'sometimes|boolean',
        ]);

        $promotion->update($validated);
        return new PromotionResource($promotion);
    }

    public function destroy(Promotion $promotion)
    {
        $this->authorize('delete', $promotion);
        $promotion->delete();
        return response()->json(['message' => 'Promotion deleted successfully']);
    }
}