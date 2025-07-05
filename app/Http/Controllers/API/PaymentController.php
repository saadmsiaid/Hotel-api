<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
        use AccessAuthorizesRequests;
    public function index()
    {
        return PaymentResource::collection(Payment::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Payment::class);

        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,debit_card,paypal,bank_transfer',
            'transaction_id' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';
        $validated['payment_date'] = now();

        $payment = Payment::create($validated);
        return new PaymentResource($payment);
    }

    public function show(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    public function update(Request $request, Payment $payment)
    {
        $this->authorize('update', $payment);

        $validated = $request->validate([
            'amount' => 'sometimes|numeric|min:0',
            'payment_method' => 'sometimes|in:credit_card,debit_card,paypal,bank_transfer',
            'status' => 'sometimes|in:pending,completed,failed',
            'transaction_id' => 'nullable|string',
            'payment_date' => 'sometimes|date',
        ]);

        $payment->update($validated);
        return new PaymentResource($payment);
    }

    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);
        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully']);
    }
}