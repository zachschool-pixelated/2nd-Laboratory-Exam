<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Record Payment for Order') }} #{{ $order->id }}
            </h2>
            <a href="{{ route('orders.show', $order->id) }}" class="btn-view">
                {{ __('← Back to Order') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Order Summary -->
            <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Customer</label>
                            <p class="text-lg font-semibold">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Total Order Amount</label>
                            <p class="text-lg font-semibold">₱{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Total Paid So Far</label>
                            <p class="text-lg font-semibold text-green-600 dark:text-green-400">₱{{ number_format($order->getTotalPaidAttribute(), 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('payments.store', $order->id) }}" method="POST">
                        @csrf

                        <!-- Amount Paid -->
                        <div class="mb-6">
                            <label for="amount_paid" class="block text-sm font-medium mb-2">
                                Amount to Pay (₱)
                            </label>
                            <input type="number" id="amount_paid" name="amount_paid" 
                                value="{{ old('amount_paid') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('amount_paid') border-red-500 @enderror"
                                placeholder="0.00" step="0.01" min="0.01" max="{{ $order->getBalanceAttribute() }}" required>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">Maximum amount: ₱{{ number_format($order->getBalanceAttribute(), 2) }}</p>
                            @error('amount_paid')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-6">
                            <label for="payment_method" class="block text-sm font-medium mb-2">
                                Payment Method
                            </label>
                            <select id="payment_method" name="payment_method" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('payment_method') border-red-500 @enderror" required>
                                <option value="">Select payment method</option>
                                <option value="Cash" @if(old('payment_method') === 'Cash') selected @endif>Cash</option>
                                <option value="Check" @if(old('payment_method') === 'Check') selected @endif>Check</option>
                                <option value="Bank Transfer" @if(old('payment_method') === 'Bank Transfer') selected @endif>Bank Transfer</option>
                                <option value="GCash" @if(old('payment_method') === 'GCash') selected @endif>GCash</option>
                                <option value="Credit Card" @if(old('payment_method') === 'Credit Card') selected @endif>Credit Card</option>
                                <option value="PayPal" @if(old('payment_method') === 'PayPal') selected @endif>PayPal</option>
                                <option value="Other" @if(old('payment_method') === 'Other') selected @endif>Other</option>
                            </select>
                            @error('payment_method')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div class="mb-6">
                            <label for="remarks" class="block text-sm font-medium mb-2">
                                Payment Remarks (Optional)
                            </label>
                            <textarea id="remarks" name="remarks" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('remarks') border-red-500 @enderror"
                                placeholder="Add any remarks about this payment...">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="btn-pay flex-1">
                                {{ __('Record Payment') }}
                            </button>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn-cancel flex-1">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Items for Reference -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Order Items (Reference)</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3">Product</th>
                                    <th class="px-6 py-3">Quantity</th>
                                    <th class="px-6 py-3">Price/kg</th>
                                    <th class="px-6 py-3">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach($order->items as $item)
                                    <tr class="bg-white dark:bg-gray-800">
                                        <td class="px-6 py-4 font-medium">{{ $item->riceItem->name }}</td>
                                        <td class="px-6 py-4">{{ number_format($item->quantity_kilograms, 2) }} kg</td>
                                        <td class="px-6 py-4">₱{{ number_format($item->price_per_kilogram, 2) }}</td>
                                        <td class="px-6 py-4 font-semibold">₱{{ number_format($item->line_total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
