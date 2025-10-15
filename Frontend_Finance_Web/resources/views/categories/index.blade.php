@extends('layouts.app')

@section('header', 'Manage Categories')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Transaction Categories</h2>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i>
                Add New Category
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Income Categories -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-green-50 dark:bg-green-900/20 border-b border-green-100 dark:border-green-800">
                    <h3 class="text-lg font-semibold text-green-800 dark:text-green-300 flex items-center">
                        <i class="fas fa-arrow-up mr-2"></i>
                        Income Categories
                    </h3>
                </div>
                <div class="p-6">
                    @if($incomeCategories->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No income categories found.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($incomeCategories as $category)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: {{ $category->color }}">
                                            <i class="{{ $category->icon ?? 'fas fa-tag' }} text-white"></i>
                                        </div>
                                        <span class="text-gray-900 dark:text-white font-medium">{{ $category->name }}</span>
                                        @if($category->is_default)
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-xs">
                                                Default
                                            </span>
                                        @endif
                                    </div>
                                    @unless($category->is_default)
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endunless
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Expense Categories -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-red-50 dark:bg-red-900/20 border-b border-red-100 dark:border-red-800">
                    <h3 class="text-lg font-semibold text-red-800 dark:text-red-300 flex items-center">
                        <i class="fas fa-arrow-down mr-2"></i>
                        Expense Categories
                    </h3>
                </div>
                <div class="p-6">
                    @if($expenseCategories->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No expense categories found.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($expenseCategories as $category)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: {{ $category->color }}">
                                            <i class="{{ $category->icon ?? 'fas fa-tag' }} text-white"></i>
                                        </div>
                                        <span class="text-gray-900 dark:text-white font-medium">{{ $category->name }}</span>
                                        @if($category->is_default)
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-xs">
                                                Default
                                            </span>
                                        @endif
                                    </div>
                                    @unless($category->is_default)
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endunless
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 