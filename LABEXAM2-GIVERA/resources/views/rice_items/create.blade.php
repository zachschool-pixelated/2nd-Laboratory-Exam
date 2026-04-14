<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Rice Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('rice-items.store') }}" method="POST">
                        @csrf

                        <!-- Product Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium mb-2">
                                Product Name
                            </label>
                            <input type="text" id="name" name="name" 
                                value="{{ old('name') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('name') border-red-500 @enderror"
                                placeholder="Enter product name" required>
                            @error('name')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Price per Kilogram -->
                        <div class="mb-6">
                            <label for="price_per_kilogram" class="block text-sm font-medium mb-2">
                                Price per Kilogram (₱)
                            </label>
                            <input type="number" id="price_per_kilogram" name="price_per_kilogram" 
                                value="{{ old('price_per_kilogram') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('price_per_kilogram') border-red-500 @enderror"
                                placeholder="0.00" step="0.01" min="0.01" required>
                            @error('price_per_kilogram')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div class="mb-6">
                            <label for="stock_quantity" class="block text-sm font-medium mb-2">
                                Initial Stock Quantity (kg)
                            </label>
                            <input type="number" id="stock_quantity" name="stock_quantity" 
                                value="{{ old('stock_quantity') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('stock_quantity') border-red-500 @enderror"
                                placeholder="0" step="0.01" min="0" required>
                            @error('stock_quantity')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium mb-2">
                                Description (Optional)
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('description') border-red-500 @enderror"
                                placeholder="Enter product description...">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="btn-create flex-1">
                                {{ __('Create Product') }}
                            </button>
                            <a href="{{ route('rice-items.index') }}" class="btn-cancel flex-1">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
