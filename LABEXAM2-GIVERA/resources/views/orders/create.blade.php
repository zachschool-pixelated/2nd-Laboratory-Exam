<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                        @csrf

                        <!-- Customer Name -->
                        <div class="mb-6">
                            <label for="customer_name" class="block text-sm font-medium mb-2">
                                Customer Name
                            </label>
                            <input type="text" id="customer_name" name="customer_name" 
                                value="{{ old('customer_name') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('customer_name') border-red-500 @enderror"
                                placeholder="Enter customer name" required>
                            @error('customer_name')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium mb-2">
                                Additional Notes (Optional)
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('notes') border-red-500 @enderror"
                                placeholder="Add any special notes for this order...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Items Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                            
                            <!-- Add Item Button -->
                            <button type="button" class="btn-create mb-4" id="addItemBtn">
                                {{ __('+ Add Item to Order') }}
                            </button>

                            @error('items')
                                <span class="text-red-500 text-sm mt-1 block mb-4">{{ $message }}</span>
                            @enderror

                            <!-- Items Container -->
                            <div id="itemsContainer" class="space-y-4">
                                @if(old('items'))
                                    @foreach(old('items') as $index => $item)
                                        <div class="item-row bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="grid grid-cols-12 gap-4">
                                                <div class="col-span-5">
                                                    <label class="block text-sm font-medium mb-2">Rice Product</label>
                                                    <select name="items[{{ $index }}][rice_item_id]" class="rice-select w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white" required>
                                                        <option value="">Select a product</option>
                                                        @foreach($riceItems as $riceItem)
                                                            <option value="{{ $riceItem->id }}" @if($item['rice_item_id'] == $riceItem->id) selected @endif>
                                                                {{ $riceItem->name }} (₱{{ number_format($riceItem->price_per_kilogram, 2) }}/kg)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-span-4">
                                                    <label class="block text-sm font-medium mb-2">Quantity (kg)</label>
                                                    <input type="number" name="items[{{ $index }}][quantity_kilograms]" 
                                                        value="{{ $item['quantity_kilograms'] }}"
                                                        class="quantity-input w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white" 
                                                        step="0.01" min="0.01" required placeholder="0.00">
                                                </div>
                                                <div class="col-span-3 flex items-end">
                                                    <button type="button" class="btn-delete w-full remove-item-btn">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Order Summary -->
                            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg border border-blue-200 dark:border-blue-800">
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">Items Count</p>
                                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400"><span id="itemsCount">0</span></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">Total Quantity</p>
                                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400"><span id="totalQuantity">0</span> kg</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">Total Amount</p>
                                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">₱<span id="totalAmount">0.00</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="btn-create flex-1">
                                {{ __('Create Order') }}
                            </button>
                            <a href="{{ route('orders.index') }}" class="btn-cancel flex-1">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const riceItems = {!! json_encode($riceItems->mapWithKeys(fn($item) => [$item->id => ['name' => $item->name, 'price' => (float)$item->price_per_kilogram, 'stock' => (float)$item->stock_quantity]])->toArray()) !!};
        let itemIndex = {{ old('items') ? count(old('items')) : 0 }};

        document.getElementById('addItemBtn').addEventListener('click', function() {
            const container = document.getElementById('itemsContainer');
            const newItem = document.createElement('div');
            newItem.className = 'item-row bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600';
            newItem.innerHTML = `
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-5">
                        <label class="block text-sm font-medium mb-2">Rice Product</label>
                        <select name="items[${itemIndex}][rice_item_id]" class="rice-select w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white" required>
                            <option value="">Select a product</option>
                            @foreach($riceItems as $riceItem)
                                <option value="{{ $riceItem->id }}">{{ $riceItem->name }} (₱{{ number_format($riceItem->price_per_kilogram, 2) }}/kg)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-4">
                        <label class="block text-sm font-medium mb-2">Quantity (kg)</label>
                        <input type="number" name="items[${itemIndex}][quantity_kilograms]" 
                            class="quantity-input w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white" 
                            step="0.01" min="0.01" required placeholder="0.00">
                    </div>
                    <div class="col-span-3 flex items-end">
                        <button type="button" class="btn-delete w-full remove-item-btn">
                            Remove
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(newItem);
            itemIndex++;
            attachEventListeners();
            updateSummary();
        });

        function attachEventListeners() {
            document.querySelectorAll('.remove-item-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.closest('.item-row').remove();
                    updateSummary();
                });
            });

            document.querySelectorAll('.rice-select, .quantity-input').forEach(input => {
                input.addEventListener('change', updateSummary);
                input.addEventListener('input', updateSummary);
            });
        }

        function updateSummary() {
            let totalAmount = 0;
            let totalQuantity = 0;
            let itemsCount = 0;

            document.querySelectorAll('.item-row').forEach(row => {
                const riceSelect = row.querySelector('.rice-select');
                const quantityInput = row.querySelector('.quantity-input');

                if (riceSelect.value && quantityInput.value) {
                    const riceItem = riceItems[riceSelect.value];
                    const quantity = parseFloat(quantityInput.value) || 0;
                    const lineTotal = quantity * riceItem.price;

                    totalAmount += lineTotal;
                    totalQuantity += quantity;
                    itemsCount++;
                }
            });

            document.getElementById('itemsCount').textContent = itemsCount;
            document.getElementById('totalQuantity').textContent = totalQuantity.toFixed(2);
            document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
        }

        attachEventListeners();
        updateSummary();
    </script>
</x-app-layout>
