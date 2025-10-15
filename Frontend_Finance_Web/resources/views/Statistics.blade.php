@extends('layouts.app')

@section('title', 'Financial Statistics - Finapp')

@section('header', 'Financial Statistics')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up">
        <!-- Average Monthly Income -->
        <div class="card bg-gradient-to-br from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Avg. Monthly Income</h3>
                <i class="fas fa-chart-line text-2xl opacity-75"></i>
            </div>
            <p class="text-3xl font-bold mb-2">Rp {{ number_format($averageMonthlyIncome, 0, ',', '.') }}</p>
            <div class="flex items-center text-sm">
                <span class="mr-2">Last 12 months</span>
                <i class="fas fa-calendar text-blue-300"></i>
            </div>
        </div>

        <!-- Average Monthly Expenses -->
        <div class="card bg-gradient-to-br from-orange-500 to-orange-600 dark:from-orange-600 dark:to-orange-700 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Avg. Monthly Expenses</h3>
                <i class="fas fa-chart-bar text-2xl opacity-75"></i>
            </div>
            <p class="text-3xl font-bold mb-2">Rp {{ number_format($averageMonthlyExpenses, 0, ',', '.') }}</p>
            <div class="flex items-center text-sm">
                <span class="mr-2">Last 12 months</span>
                <i class="fas fa-calendar text-orange-300"></i>
            </div>
        </div>

        <!-- Average Savings Rate -->
        <div class="card bg-gradient-to-br from-teal-500 to-teal-600 dark:from-teal-600 dark:to-teal-700 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Avg. Savings Rate</h3>
                <i class="fas fa-piggy-bank text-2xl opacity-75"></i>
            </div>
            <p class="text-3xl font-bold mb-2">{{ number_format($averageSavingsRate, 1) }}%</p>
            <div class="flex items-center text-sm">
                <span class="mr-2">Last 12 months</span>
                <i class="fas fa-chart-pie text-teal-300"></i>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="card bg-gradient-to-br from-purple-500 to-purple-600 dark:from-purple-600 dark:to-purple-700 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Total Transactions</h3>
                <i class="fas fa-exchange-alt text-2xl opacity-75"></i>
            </div>
            <p class="text-3xl font-bold mb-2">{{ number_format($totalTransactions) }}</p>
            <div class="flex items-center text-sm">
                <span class="mr-2">All time</span>
                <i class="fas fa-history text-purple-300"></i>
            </div>
        </div>
    </div>

    <!-- Visualization: Average Savings Rate Over Time -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center"><i class="fas fa-chart-line mr-2"></i>Average Savings Rate Over Time</h2>
        <canvas id="savingsRateTrendChart" class="w-full h-64"></canvas>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="100">
        <!-- Income vs Expenses Trend -->
        <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-chart-line text-indigo-500 mr-2"></i>
                    Income vs Expenses Trend
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
                <canvas id="incomeExpensesTrendChart"></canvas>
            </div>
        </div>

        <!-- Category Analysis -->
        <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-chart-pie text-indigo-500 mr-2"></i>
                    Category Analysis
                </h3>
                <select class="form-select bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg">
                    <option value="expenses">Expenses</option>
                    <option value="income">Income</option>
                </select>
            </div>
            <div class="h-80">
                <canvas id="categoryAnalysisChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Additional Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="200">
        <!-- Monthly Savings Rate -->
        <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-chart-area text-indigo-500 mr-2"></i>
                    Monthly Savings Rate
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
                <canvas id="savingsRateChart"></canvas>
            </div>
        </div>

        <!-- Transaction Distribution -->
        <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-chart-bar text-indigo-500 mr-2"></i>
                    Transaction Distribution
                </h3>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 hover:bg-indigo-200 dark:hover:bg-indigo-800 transition-colors">
                        Daily
                    </button>
                    <button class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Weekly
                    </button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="transactionDistributionChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Income vs Expenses Trend Chart
    const incomeExpensesTrendCtx = document.getElementById('incomeExpensesTrendChart').getContext('2d');
    const incomeExpensesTrendChart = new Chart(incomeExpensesTrendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyTrends->pluck('month')) !!},
            datasets: [
                {
                    label: 'Income',
                    data: {!! json_encode($monthlyTrends->pluck('income')) !!},
                    borderColor: themeColors.chart.income,
                    backgroundColor: themeColors.chart.income + '20',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Expenses',
                    data: {!! json_encode($monthlyTrends->pluck('expenses')) !!},
                    borderColor: themeColors.chart.expenses,
                    backgroundColor: themeColors.chart.expenses + '20',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: themeColors.text.primary,
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: themeColors.tooltip.background,
                    titleColor: themeColors.tooltip.title,
                    bodyColor: themeColors.tooltip.body,
                    borderColor: themeColors.tooltip.border,
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: themeColors.grid,
                        drawBorder: false
                    },
                    ticks: {
                        color: themeColors.text.secondary,
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    grid: {
                        color: themeColors.grid,
                        drawBorder: false
                    },
                    ticks: {
                        color: themeColors.text.secondary,
                        callback: function(value) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0,
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value);
                        }
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            animation: {
                duration: 750,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Category Analysis Chart
    const categoryAnalysisCtx = document.getElementById('categoryAnalysisChart').getContext('2d');
    const categoryAnalysisChart = new Chart(categoryAnalysisCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(collect($categoryData)->pluck('category_name')) !!},
            datasets: [{
                data: {!! json_encode(collect($categoryData)->pluck('total')) !!},
                backgroundColor: {!! json_encode(collect($categoryData)->pluck('color')) !!},
                borderWidth: 2,
                borderColor: themeColors.background.primary
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: themeColors.text.primary,
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: themeColors.tooltip.background,
                    titleColor: themeColors.tooltip.title,
                    bodyColor: themeColors.tooltip.body,
                    borderColor: themeColors.tooltip.border,
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }).format(value)} (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '70%',
            animation: {
                duration: 750,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Monthly Savings Rate Chart
    const savingsRateCtx = document.getElementById('savingsRateChart').getContext('2d');
    const savingsRateChart = new Chart(savingsRateCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyTrends->pluck('month')) !!},
            datasets: [{
                label: 'Savings Rate',
                data: {!! json_encode($monthlyTrends->pluck('savings_rate')) !!},
                borderColor: themeColors.chart.savings,
                backgroundColor: themeColors.chart.savings + '20',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: themeColors.text.primary,
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: themeColors.tooltip.background,
                    titleColor: themeColors.tooltip.title,
                    bodyColor: themeColors.tooltip.body,
                    borderColor: themeColors.tooltip.border,
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return `Savings Rate: ${context.parsed.y.toFixed(1)}%`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: themeColors.grid,
                        drawBorder: false
                    },
                    ticks: {
                        color: themeColors.text.secondary,
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    grid: {
                        color: themeColors.grid,
                        drawBorder: false
                    },
                    ticks: {
                        color: themeColors.text.secondary,
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            animation: {
                duration: 750,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Transaction Distribution Chart
    const transactionDistributionCtx = document.getElementById('transactionDistributionChart').getContext('2d');
    const transactionDistributionChart = new Chart(transactionDistributionCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($transactionDistribution->pluck('date')) !!},
            datasets: [{
                label: 'Transactions',
                data: {!! json_encode($transactionDistribution->pluck('count')) !!},
                backgroundColor: themeColors.chart.transactions,
                borderColor: themeColors.chart.transactions,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: themeColors.tooltip.background,
                    titleColor: themeColors.tooltip.title,
                    bodyColor: themeColors.tooltip.body,
                    borderColor: themeColors.tooltip.border,
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return `Transactions: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: themeColors.grid,
                        drawBorder: false
                    },
                    ticks: {
                        color: themeColors.text.secondary,
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    grid: {
                        color: themeColors.grid,
                        drawBorder: false
                    },
                    ticks: {
                        color: themeColors.text.secondary,
                        precision: 0
                    }
                }
            },
            animation: {
                duration: 750,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Store chart instances for theme updates
    window.charts = {
        incomeExpensesTrend: incomeExpensesTrendChart,
        categoryAnalysis: categoryAnalysisChart,
        savingsRate: savingsRateChart,
        transactionDistribution: transactionDistributionChart
    };

    // Period selector functionality
    const periodButtons = document.querySelectorAll('.card button');
    periodButtons.forEach(button => {
        button.addEventListener('click', () => {
            const parentCard = button.closest('.card');
            const buttons = parentCard.querySelectorAll('button');
            buttons.forEach(btn => {
                btn.classList.remove('bg-indigo-100', 'dark:bg-indigo-900', 'text-indigo-800', 'dark:text-indigo-200');
                btn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
            });
            button.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
            button.classList.add('bg-indigo-100', 'dark:bg-indigo-900', 'text-indigo-800', 'dark:text-indigo-200');
            // Implement period change logic here
        });
    });

    // Category selector functionality
    const categorySelect = document.querySelector('select');
    categorySelect.addEventListener('change', (e) => {
        // Implement category change logic here
    });

    const ctx = document.getElementById('savingsRateTrendChart').getContext('2d');
    const savingsRateTrendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($savingsRateTrends ?? [])) !!},
            datasets: [{
                label: 'Savings Rate (%)',
                data: {!! json_encode(array_values($savingsRateTrends ?? [])) !!},
                borderColor: themeColors.chart.trend,
                backgroundColor: themeColors.chart.trend + '20',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { color: themeColors.text.primary }
                },
                tooltip: {
                    backgroundColor: themeColors.tooltip.background,
                    titleColor: themeColors.tooltip.title,
                    bodyColor: themeColors.tooltip.body,
                    borderColor: themeColors.tooltip.border,
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return `Savings Rate: ${context.parsed.y.toFixed(2)}%`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: themeColors.grid },
                    ticks: { color: themeColors.text.secondary }
                },
                y: {
                    grid: { color: themeColors.grid },
                    ticks: { color: themeColors.text.secondary }
                }
            }
        }
    });
});
</script>
@endpush