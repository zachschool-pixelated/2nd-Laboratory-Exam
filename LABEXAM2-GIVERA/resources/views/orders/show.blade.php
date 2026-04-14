<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Order Details') }} #{{ $order->id }}
            </h2>
            <a href="{{ route('orders.index') }}" class="btn-view">
                {{ __('← Back to Orders') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Success Messages -->
            @if ($message = Session::get('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ $message }}
                </div>
            @endif

            <!-- Order Information Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Order Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Customer Name</label>
                            <p class="text-xl font-semibold">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Order Status</label>
                            <p class="text-xl font-semibold">
                                <span class="px-3 py-1 rounded-full text-sm @if($order->payment_status === 'Paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                    {{ $order->payment_status }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Order Date</label>
                            <p class="text-xl font-semibold">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Total Amount</label>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">₱{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>
                    @if($order->notes)
                        <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900 rounded border border-blue-200 dark:border-blue-800">
                            <label class="text-sm text-gray-600 dark:text-gray-400">Notes</label>
                            <p class="text-gray-700 dark:text-gray-300">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3">Product Name</th>
                                    <th class="px-6 py-3">Quantity (kg)</th>
                                    <th class="px-6 py-3">Price/kg</th>
                                    <th class="px-6 py-3">Line Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach($order->items as $item)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 font-medium">{{ $item->riceItem->name }}</td>
                                        <td class="px-6 py-4">{{ number_format($item->quantity_kilograms, 2) }}</td>
                                        <td class="px-6 py-4">₱{{ number_format($item->price_per_kilogram, 2) }}</td>
                                        <td class="px-6 py-4 font-semibold">₱{{ number_format($item->line_total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <label class="text-sm text-gray-600 dark:text-gray-400">Total Order Amount</label>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">₱{{ number_format($order->total_amount, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <label class="text-sm text-gray-600 dark:text-gray-400">Total Paid</label>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">₱{{ number_format($order->getTotalPaidAttribute(), 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <label class="text-sm text-gray-600 dark:text-gray-400">Remaining Balance</label>
                    <p class="text-3xl font-bold @if($order->getBalanceAttribute() > 0) text-red-600 dark:text-red-400 @else text-green-600 dark:text-green-400 @endif">₱{{ number_format($order->getBalanceAttribute(), 2) }}</p>
                </div>
            </div>

            <!-- Payments History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Payment History</h3>
                        @if($order->getBalanceAttribute() > 0)
                            <a href="{{ route('payments.create', $order->id) }}" class="btn-pay">
                                {{ __('+ Record Payment') }}
                            </a>
                        @else
                            <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Fully Paid
                            </span>
                        @endif
                    </div>

                    @if($order->payments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3">Payment ID</th>
                                        <th class="px-6 py-3">Amount</th>
                                        <th class="px-6 py-3">Payment Method</th>
                                        <th class="px-6 py-3">Date</th>
                                        <th class="px-6 py-3">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($order->payments as $payment)
                                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 font-medium">#{{ $payment->id }}</td>
                                            <td class="px-6 py-4 font-semibold">₱{{ number_format($payment->amount_paid, 2) }}</td>
                                            <td class="px-6 py-4">{{ $payment->payment_method }}</td>
                                            <td class="px-6 py-4">{{ $payment->paid_at->format('M d, Y h:i A') }}</td>
                                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $payment->remarks ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 mb-4">No payments recorded yet for this order.</p>
                            @if($order->getBalanceAttribute() > 0)
                                <a href="{{ route('payments.create', $order->id) }}" class="btn-pay">
                                    {{ __('Record Payment Now') }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
