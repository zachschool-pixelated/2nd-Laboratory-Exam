<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with('order')->latest('paid_at')->latest()->paginate(10);

        return view('payments.index', compact('payments'));
    }

    public function create(Order $order): View
    {
        $order->load(['items.riceItem', 'payments']);

        return view('payments.create', compact('order'));
    }

    public function store(Request $request, Order $order): RedirectResponse
    {
        $remainingBalance = max(0, (float) $order->total_amount - (float) $order->payments()->sum('amount_paid'));

        $validated = $request->validate([
            'amount_paid' => ['required', 'numeric', 'min:0.01', 'max:'.$remainingBalance],
            'payment_method' => ['required', 'string', 'max:50'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ], [
            'amount_paid.max' => 'Payment cannot exceed the remaining order balance.',
        ]);

        Payment::create([
            'order_id' => $order->id,
            'amount_paid' => $validated['amount_paid'],
            'payment_method' => $validated['payment_method'],
            'paid_at' => Carbon::now(),
            'remarks' => $validated['remarks'] ?? null,
        ]);

        $updatedTotalPaid = (float) $order->payments()->sum('amount_paid');
        $order->update([
            'payment_status' => $updatedTotalPaid >= (float) $order->total_amount ? 'Paid' : 'Unpaid',
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Payment processed successfully.');
    }
}
