<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

/**
 * @method Authenticatable|null user()
 */
class PaymentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        /** @var Authenticatable|null $user */
        $user = auth()->user();
        $payments = $user ? Payment::where('user_id', $user->id)->get() : collect([]);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $reservations = \App\Models\Reservation::all();
        return view('payments.create', compact('reservations'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Payment::class);

        /** @var Authenticatable|null $user */
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Please log in.']);
        }

        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,debit_card,paypal,bank_transfer',
            'transaction_id' => 'nullable|string',
        ]);

        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';
        $validated['payment_date'] = now();

        Payment::create($validated);
        return redirect()->route('payments.index')->with('success', 'Payment created successfully!');
    }

    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);
        return view('payments.show', compact('payment'));
    }
}