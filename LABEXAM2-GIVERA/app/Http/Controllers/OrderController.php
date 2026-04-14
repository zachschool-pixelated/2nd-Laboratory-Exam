<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RiceItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['items.riceItem', 'payments'])->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create(): View
    {
        $riceItems = RiceItem::orderBy('name')->get();

        return view('orders.create', compact('riceItems'));
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.rice_item_id' => ['required', 'exists:rice_items,id'],
            'items.*.quantity_kilograms' => ['required', 'numeric', 'min:0.01'],
        ]);

        $order = DB::transaction(function () use ($validated) {
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'total_amount' => 0,
                'payment_status' => 'Unpaid',
                'notes' => $validated['notes'] ?? null,
            ]);

            $totalAmount = 0;

            foreach ($validated['items'] as $itemData) {
                $riceItem = RiceItem::lockForUpdate()->findOrFail($itemData['rice_item_id']);
                $quantity = (float) $itemData['quantity_kilograms'];

                if ((float) $riceItem->stock_quantity < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => ["Insufficient stock for {$riceItem->name}."],
                    ]);
                }

                $price = (float) $riceItem->price_per_kilogram;
                $lineTotal = $quantity * $price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'rice_item_id' => $riceItem->id,
                    'quantity_kilograms' => $quantity,
                    'price_per_kilogram' => $price,
                    'line_total' => $lineTotal,
                ]);

                $riceItem->decrement('stock_quantity', $quantity);
                $totalAmount += $lineTotal;
            }

            $order->update(['total_amount' => $totalAmount]);

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Order created successfully.');
    }

    public function show(Order $order): View
    {
        $order->load(['items.riceItem', 'payments']);

        return view('orders.show', compact('order'));
    }
}
