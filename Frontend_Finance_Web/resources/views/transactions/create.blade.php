@extends('layouts.app')

@section('title', 'Create Transaction - Finapp')

@section('header', 'Record New Transaction')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6" data-aos="fade-up">
        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Transaction Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transaction Type</label>
                <select name="type" id="type" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Select Type</option>
                    <option value="income" {{ old('type', 'income') == 'income' ? 'selected' : '' }}>Income</option>
                    <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                <select name="category_id" id="category" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    data-old-category="{{ old('category_id') }}">
                    <option value="">Select Category</option>
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount -->
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount (Rp)</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="amount" id="amount" step="0.01" min="0" required
                        value="{{ old('amount') }}"
                        class="block w-full pl-12 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="0.00">
                </div>
                @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Transaction Date -->
            <div>
                <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transaction Date</label>
                <input type="date" name="transaction_date" id="transaction_date" required
                    value="{{ old('transaction_date', date('Y-m-d')) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('transaction_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Enter transaction description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('transactions.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                    Record Transaction
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const transactionTypeSelect = document.getElementById('type');
        const categorySelect = document.getElementById('category');
        const oldCategoryId = categorySelect.dataset.oldCategory;

        console.log('DOM Content Loaded. Initializing category dropdown logic.'); // Debugging: DOM loaded
        console.log('Initial transactionTypeSelect.value:', transactionTypeSelect.value); // Debugging: initial value

        async function updateCategoriesDropdown() {
            const selectedType = transactionTypeSelect.value;
            categorySelect.innerHTML = '<option value="">Select Category</option>'; // Clear existing options

            console.log(`Attempting to fetch categories for type: ${selectedType}`); // Debugging: attempting fetch

            if (selectedType) {
                try {
                    const response = await fetch(`/categories/type/${selectedType}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const categories = await response.json();

                    console.log('Categories fetched successfully:', categories); // Debugging: fetched categories

                    if (categories.length === 0) {
                        console.log('No categories found for this type in the database.');
                    }

                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        if (oldCategoryId && String(category.id) === oldCategoryId) {
                            option.selected = true;
                        }
                        categorySelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error fetching categories:', error);
                    // Optionally, display an error message to the user
                }
            } else {
                console.log('Selected transaction type is empty. Not fetching categories.'); // Debugging: empty type
            }
        }

        // Initial call on page load
        updateCategoriesDropdown();

        // Update when transaction type changes
        transactionTypeSelect.addEventListener('change', () => {
            console.log('Transaction type changed. New value:', transactionTypeSelect.value); // Debugging: type changed
            // Clear oldCategoryId to prevent incorrect re-selection on type change
            categorySelect.dataset.oldCategory = ''; 
            updateCategoriesDropdown();
        });

        // Listen for window focus to refresh categories if user returns from category management
        window.addEventListener('focus', updateCategoriesDropdown);
    });
</script>
@endpush
@endsection 