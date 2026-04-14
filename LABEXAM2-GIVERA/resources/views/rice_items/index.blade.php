<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Rice Products Management') }}
            </h2>
            <a href="{{ route('rice-items.create') }}" class="btn-create">
                {{ __('+ Add New Product') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if ($message = Session::get('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ $message }}
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $message }}
                </div>
            @endif

            <!-- Rice Items Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($riceItems->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3">Product Name</th>
                                        <th class="px-6 py-3">Price per kg</th>
                                        <th class="px-6 py-3">Stock Quantity (kg)</th>
                                        <th class="px-6 py-3">Description</th>
                                        <th class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($riceItems as $item)
                                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 font-medium">{{ $item->name }}</td>
                                            <td class="px-6 py-4">₱{{ number_format($item->price_per_kilogram, 2) }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1 rounded-full @if($item->stock_quantity > 50) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @elseif($item->stock_quantity > 10) bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                                    {{ number_format($item->stock_quantity, 2) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                                {{ Str::limit($item->description, 50) ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 flex gap-2">
                                                <a href="{{ route('rice-items.edit', $item->id) }}" class="btn-edit">
                                                    Edit
                                                </a>
                                                <form action="{{ route('rice-items.destroy', $item->id) }}" method="POST" class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-delete">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $riceItems->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400">No rice products found.</p>
                            <a href="{{ route('rice-items.create') }}" class="btn-create mt-4 inline-block">
                                {{ __('Create First Product') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
