<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payments Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Messages -->
            @if ($message = Session::get('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ $message }}
                </div>
            @endif

            <!-- Payments Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($payments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3">Payment ID</th>
                                        <th class="px-6 py-3">Order ID</th>
                                        <th class="px-6 py-3">Customer</th>
                                        <th class="px-6 py-3">Amount Paid</th>
                                        <th class="px-6 py-3">Payment Method</th>
                                        <th class="px-6 py-3">Date</th>
                                        <th class="px-6 py-3">Remarks</th>
                                        <th class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($payments as $payment)
                                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 font-medium">#{{ $payment->id }}</td>
                                            <td class="px-6 py-4">#{{ $payment->order->id }}</td>
                                            <td class="px-6 py-4">{{ $payment->order->customer_name }}</td>
                                            <td class="px-6 py-4 font-semibold text-green-600 dark:text-green-400">₱{{ number_format($payment->amount_paid, 2) }}</td>
                                            <td class="px-6 py-4">{{ $payment->payment_method }}</td>
                                            <td class="px-6 py-4">{{ $payment->paid_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                                {{ Str::limit($payment->remarks, 30) ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('orders.show', $payment->order->id) }}" class="btn-view">
                                                    View Order
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $payments->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400">No payments recorded yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
