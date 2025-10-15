@extends('layouts.app')

@section('title', 'Dashboard - Finapp')

@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up">
        <!-- Total Balance Card -->
        <div class="card bg-gradient-to-br from-indigo-500 to-indigo-600 dark:from-indigo-600 dark:to-indigo-700 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white dark:text-white">Total Balance</h3>
                <i class="fas fa-wallet text-2xl opacity-75 text-white dark:text-white"></i>
            </div>
            <p class="text-3xl font-bold mb-2 text-white dark:text-white">Rp {{ number_format($totalBalance, 0, ',', '.') }}</p>
            <div class="flex items-center text-sm text-white dark:text-white">
                <span class="mr-2">Last 30 days</span>
                <i class="fas fa-arrow-trend-up text-green-300 dark:text-green-400"></i>
            </div>
        </div>

        <!-- Total Income Card -->
        <div class="card bg-gradient-to-br from-green-500 to-green-600 dark:from-green-600 dark:to-green-700 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white dark:text-white">Total Income</h3>
                <i class="fas fa-arrow-trend-up text-2xl opacity-75 text-white dark:text-white"></i>
            </div>
            <p class="text-3xl font-bold mb-2 text-white dark:text-white">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            <div class="flex items-center text-sm text-white dark:text-white">
                <span class="mr-2">This Month</span>
                <i class="fas fa-calendar text-green-300 dark:text-green-400"></i>
        </div>
    </div>

    <!-- Total Expenses Card -->
        <div class="card bg-gradient-to-br from-red-500 to-red-600 dark:from-red-600 dark:to-red-700 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white dark:text-white">Total Expenses</h3>
                <i class="fas fa-arrow-trend-down text-2xl opacity-75 text-white dark:text-white"></i>
            </div>
            <p class="text-3xl font-bold mb-2 text-white dark:text-white">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
            <div class="flex items-center text-sm text-white dark:text-white">
                <span class="mr-2">This Month</span>
                <i class="fas fa-calendar text-red-300 dark:text-red-400"></i>
            </div>
        </div>

        <!-- Savings Rate Card -->
        <div class="card bg-gradient-to-br from-purple-500 to-purple-600 dark:from-purple-600 dark:to-purple-700 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white dark:text-white">Savings Rate</h3>
                <i class="fas fa-piggy-bank text-2xl opacity-75 text-white dark:text-white"></i>
            </div>
            <p class="text-3xl font-bold mb-2 text-white dark:text-white">{{ number_format($savingsRate, 1) }}%</p>
            <div class="flex items-center text-sm text-white dark:text-white">
                <span class="mr-2">This Month</span>
                <i class="fas fa-chart-line text-purple-300 dark:text-purple-400"></i>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="100">
        <!-- Monthly Trends Chart -->
        <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-chart-line text-indigo-500 mr-2"></i>
                    Monthly Trends
                </h3>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 hover:bg-indigo-200 dark:hover:bg-indigo-800 transition-colors">
                        6M
                    </button>
                    <button class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        1Y
                    </button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="monthlyTrendsChart" width="400" height="300"></canvas>
        </div>
    </div>

        <!-- Category Distribution Chart -->
        <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-chart-pie text-indigo-500 mr-2"></i>
                    Category Distribution
                </h3>
                <select class="form-select bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg">
                    <option value="expenses">Expenses</option>
                    <option value="income">Income</option>
                </select>
            </div>
            <div class="h-80">
                <canvas id="categoryDistributionChart" width="400" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-history text-indigo-500 mr-2"></i>
                    Recent Transactions
                </h3>
                <a href="{{ route('reports.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
            View All
        </a>
    </div>
        </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentTransactions as $transaction)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $transaction->transaction_date ? $transaction->transaction_date->format('d M Y') : '-' }}
                                </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            @if($transaction->category)
                                <div class="flex items-center space-x-2">
                                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $transaction->category->color }}"></span>
                                    <span>{{ $transaction->category->name }}</span>
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                            {{ $transaction->description ?? '-' }}
                                </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium 
                            {{ $transaction->type === 'income' 
                                ? 'text-green-600 dark:text-green-400' 
                                : 'text-red-600 dark:text-red-400' }}">
                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ ucfirst($transaction->type) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            No recent transactions found
                                </td>
                            </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize charts after a small delay to ensure DOM is ready
        setTimeout(initializeCharts, 50);
    });

    function initializeCharts() {
        const isDarkMode = document.documentElement.classList.contains('dark');
        const textColor = isDarkMode ? '#E5E7EB' : '#374151';
        const gridColor = isDarkMode ? '#374151' : '#E5E7EB';

        // Initialize category distribution chart
        const categoryCtx = document.getElementById('categoryDistributionChart');
        if (categoryCtx) {
            const categoryChart = new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(collect($categorySummary)->pluck('category_name')) !!},
                    datasets: [{
                        data: {!! json_encode(collect($categorySummary)->pluck('total')) !!},
                        backgroundColor: {!! json_encode(collect($categorySummary)->pluck('category_color')) !!},
                        borderWidth: 2,
                        borderColor: isDarkMode ? '#1F2937' : '#FFFFFF',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: textColor,
                                boxWidth: 15,
                                padding: 15
                            }
                        }
                    }
                }
            });

            // Add event listener for the type selector
            const typeSelector = document.querySelector('.form-select');
            if (typeSelector) {
                typeSelector.addEventListener('change', function() {
                    const type = this.value;
                    const filteredData = {!! json_encode($categorySummary) !!}.filter(item => item.type === type);
                    
                    categoryChart.data.labels = filteredData.map(item => item.category_name);
                    categoryChart.data.datasets[0].data = filteredData.map(item => item.total);
                    categoryChart.data.datasets[0].backgroundColor = filteredData.map(item => item.category_color);
                    categoryChart.update();
                });
            }
        }

        // Initialize monthly trends chart if it exists
        const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart');
        if (monthlyTrendsCtx) {
            let monthlyTrendsChart = null;

            // Add fallback colors
            const fallbackColors = {
                income: '#10B981',
                expense: '#EF4444',
                net: '#3B82F6',
                text: '#1F2937',
                grid: '#E5E7EB'
            };

            function getSafeColor(type) {
                try {
                    const theme = getCurrentTheme();
                    return themeColors?.[theme]?.chart?.[type]?.[0] || fallbackColors[type];
                } catch (e) {
                    return fallbackColors[type];
                }
            }

            function validateChartData(data) {
                if (!data || typeof data !== 'object') return [];
                return Object.entries(data).map(([key, value]) => ({
                    month: key,
                    income: Number(value?.income || 0),
                    expense: Number(value?.expense || 0),
                    net: Number(value?.net || 0)
                }));
            }

            function initializeMonthlyTrendsChart() {
                if (monthlyTrendsChart) {
                    monthlyTrendsChart.destroy();
                }

                const ctx = monthlyTrendsCtx.getContext('2d');
                if (!ctx) return;

                // Validate and process the data
                const rawMonthlyTrends = @json($monthlyTrends ?? []);
                const validatedData = validateChartData(rawMonthlyTrends);
                
                const monthlyLabels = validatedData.map(d => d.month);
                const monthlyIncomeData = validatedData.map(d => d.income);
                const monthlyExpenseData = validatedData.map(d => d.expense);
                const monthlyNetData = validatedData.map(d => d.net);

                // Ensure we have at least one data point
                if (monthlyLabels.length === 0) {
                    monthlyLabels.push('No Data');
                    monthlyIncomeData.push(0);
                    monthlyExpenseData.push(0);
                    monthlyNetData.push(0);
                }

                const chartConfig = {
                    type: 'line',
                    data: {
                        labels: monthlyLabels,
                        datasets: [
                            {
                                label: 'Income',
                                data: monthlyIncomeData,
                                borderColor: getSafeColor('income'),
                                backgroundColor: getSafeColor('income') + '20',
                                tension: 0.4,
                                fill: true,
                                borderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Expenses',
                                data: monthlyExpenseData,
                                borderColor: getSafeColor('expense'),
                                backgroundColor: getSafeColor('expense') + '20',
                                tension: 0.4,
                                fill: true,
                                borderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Net',
                                data: monthlyNetData,
                                borderColor: getSafeColor('net'),
                                backgroundColor: getSafeColor('net') + '20',
                                tension: 0.4,
                                fill: true,
                                borderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 750,
                            easing: 'easeInOutQuart'
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: fallbackColors.text,
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            title: {
                                display: true,
                                text: 'Monthly Trends',
                                color: fallbackColors.text,
                                padding: {
                                    top: 10,
                                    bottom: 20
                                }
                            },
                            tooltip: {
                                enabled: true,
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: 'rgba(255, 255, 255, 0.2)',
                                borderWidth: 1
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: true,
                                    color: fallbackColors.grid,
                                    drawBorder: true
                                },
                                ticks: {
                                    color: fallbackColors.text,
                                    padding: 10
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: true,
                                    color: fallbackColors.grid,
                                    drawBorder: true
                                },
                                ticks: {
                                    color: fallbackColors.text,
                                    padding: 10,
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                };

                try {
                    monthlyTrendsChart = new Chart(ctx, chartConfig);
                } catch (error) {
                    console.error('Error initializing monthly trends chart:', error);
                }
            }

            // Initialize charts when DOM is loaded
            try {
                initializeMonthlyTrendsChart();
            } catch (error) {
                console.error('Error during chart initialization:', error);
            }

            // Update charts on theme change
            document.addEventListener('themeChanged', function() {
                try {
                    initializeMonthlyTrendsChart();
                } catch (error) {
                    console.error('Error updating chart on theme change:', error);
                }
            });
        }
    }
</script>
@endpush
@endsection