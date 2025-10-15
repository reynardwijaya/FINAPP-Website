@extends('layouts.app')

@section('title', 'Reports - Finapp')

@section('header', 'Financial Reports')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6" data-aos="fade-up">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Financial Reports</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Track and analyze your financial transactions</p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Income -->
        <div class="card bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-200" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-medium">Total Income</h3>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2">
                        Rp {{ number_format($transactions->where('type', 'income')->sum('amount'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-800 flex items-center justify-center">
                    <i class="fas fa-arrow-up text-green-600 dark:text-green-400 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-green-600 dark:text-green-400">
                    <span class="font-medium">This Month</span>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="card bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900 dark:to-red-800 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-200" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-medium">Total Expenses</h3>
                    <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-2">
                        Rp {{ number_format($transactions->where('type', 'expense')->sum('amount'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-800 flex items-center justify-center">
                    <i class="fas fa-arrow-down text-red-600 dark:text-red-400 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-red-600 dark:text-red-400">
                    <span class="font-medium">This Month</span>
                </div>
            </div>
        </div>

        <!-- Net Balance -->
        <div class="card bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-200" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-medium">Net Balance</h3>
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-2">
                        Rp {{ number_format($transactions->where('type', 'income')->sum('amount') - $transactions->where('type', 'expense')->sum('amount'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-800 flex items-center justify-center">
                    <i class="fas fa-balance-scale text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-blue-600 dark:text-blue-400">
                    <span class="font-medium">This Month</span>
                </div>
            </div>
        </div>

        <!-- Savings Rate -->
        <div class="card bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-200" data-aos="fade-up" data-aos-delay="400">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-medium">Savings Rate</h3>
                    @php
                        $income = $transactions->where('type', 'income')->sum('amount');
                        $expenses = $transactions->where('type', 'expense')->sum('amount');
                        $savingsRate = $income > 0 ? (($income - $expenses) / $income) * 100 : 0;
                    @endphp
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-2">
                        {{ number_format($savingsRate, 1) }}%
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-800 flex items-center justify-center">
                    <i class="fas fa-piggy-bank text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-purple-600 dark:text-purple-400">
                    <span class="font-medium">This Month</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 