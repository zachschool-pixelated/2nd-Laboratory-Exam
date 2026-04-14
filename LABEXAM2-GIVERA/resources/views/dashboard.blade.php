<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard - System Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Rice Products Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rice Products</p>
                                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $riceCount }}</p>
                            </div>
                            <div class="text-4xl opacity-20">🌾</div>
                        </div>
                        <a href="{{ route('rice-items.index') }}" class="mt-4 inline-block text-blue-600 dark:text-blue-400 hover:underline">
                            Manage Products →
                        </a>
                    </div>
                </div>

                <!-- Total Orders Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Orders</p>
                                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $orderCount }}</p>
                            </div>
                            <div class="text-4xl opacity-20">🛒</div>
                        </div>
                        <a href="{{ route('orders.index') }}" class="mt-4 inline-block text-green-600 dark:text-green-400 hover:underline">
                            View Orders →
                        </a>
                    </div>
                </div>

                <!-- Paid Orders Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Paid Orders</p>
                                <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">{{ $paidOrderCount }}</p>
                            </div>
                            <div class="text-4xl opacity-20">✓</div>
                        </div>
                        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $orderCount > 0 ? round(($paidOrderCount / $orderCount) * 100) : 0 }}% of orders
                        </p>
                    </div>
                </div>

                <!-- Payments Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Payments</p>
                                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">{{ $paymentCount }}</p>
                            </div>
                            <div class="text-4xl opacity-20">💳</div>
                        </div>
                        <a href="{{ route('payments.index') }}" class="mt-4 inline-block text-purple-600 dark:text-purple-400 hover:underline">
                            View Payments →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('rice-items.create') }}" class="btn-create text-center">
                            + Add Rice Product
                        </a>
                        <a href="{{ route('orders.create') }}" class="btn-create text-center">
                            + Create New Order
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn-view text-center">
                            View All Orders
                        </a>
                        <a href="{{ route('payments.index') }}" class="btn-pay text-center">
                            View Payments
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-3">📋 System Features</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <span class="text-green-600 dark:text-green-400 mr-3">✓</span>
                            <span class="text-sm">Login & Authentication - Secure user access control</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-600 dark:text-green-400 mr-3">✓</span>
                            <span class="text-sm">Rice Menu Management - Add, edit, delete products</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-600 dark:text-green-400 mr-3">✓</span>
                            <span class="text-sm">Order Management - Create and track customer orders</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-600 dark:text-green-400 mr-3">✓</span>
                            <span class="text-sm">Payment Processing - Record and track payments</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
