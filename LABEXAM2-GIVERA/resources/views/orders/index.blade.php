<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Orders Management') }}
            </h2>
            <a href="{{ route('orders.create') }}" class="btn-create">
                {{ __('+ Create New Order') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Messages -->
            @if ($message = Session::get('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ $message }}
                </div>
            @endif

            <!-- Orders Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3">Order ID</th>
                                        <th class="px-6 py-3">Customer Name</th>
                                        <th class="px-6 py-3">Total Amount</th>
                                        <th class="px-6 py-3">Items Count</th>
                                        <th class="px-6 py-3">Payments</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($orders as $order)
                                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 font-medium">#{{ $order->id }}</td>
                                            <td class="px-6 py-4">{{ $order->customer_name }}</td>
                                            <td class="px-6 py-4 font-semibold">₱{{ number_format($order->total_amount, 2) }}</td>
                                            <td class="px-6 py-4 text-center">{{ $order->items->count() }}</td>
                                            <td class="px-6 py-4">
                                                <span class="text-xs">
                                                    ₱{{ number_format($order->getTotalPaidAttribute(), 2) }} / ₱{{ number_format($order->total_amount, 2) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold @if($order->payment_status === 'Paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                                    {{ $order->payment_status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 flex gap-2">
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn-view">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400">No orders found.</p>
                            <a href="{{ route('orders.create') }}" class="btn-create mt-4 inline-block">
                                {{ __('Create First Order') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
