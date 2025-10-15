@extends('layouts.app')

@section('title', 'Financial Analysis - Finapp')

@section('header', 'Financial Analysis')

@push('styles')
<style>
    .chart-container {
        position: relative;
        height: 400px;
        width: 100%;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
    .chart-container.loaded {
        opacity: 1;
    }
    .content-wrapper {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
    .content-wrapper.loaded {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 max-w-7xl space-y-6 content-wrapper">
    <!-- Analysis Type Toggle -->
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 sm:p-6" data-aos="fade-up">
        <div class="flex flex-wrap justify-end gap-2 sm:gap-4">
            <a href="{{ route('analysis.index', ['type' => 'monthly']) }}" 
               class="px-3 sm:px-4 py-2 rounded-md transition-colors duration-150 text-sm sm:text-base {{ $analysisType === 'monthly' 
                    ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-md' 
                    : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <i class="fas fa-calendar-alt mr-2"></i>
                Monthly
            </a>
            <a href="{{ route('analysis.index', ['type' => 'yearly']) }}"
               class="px-3 sm:px-4 py-2 rounded-md transition-colors duration-150 text-sm sm:text-base {{ $analysisType === 'yearly' 
                    ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-md' 
                    : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <i class="fas fa-calendar mr-2"></i>
                Yearly
            </a>
        </div>
    </div>

    <!-- Financial Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <div class="card bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg shadow-lg p-4 sm:p-6 transform hover:scale-105 transition-transform duration-200" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-medium">Total Income</h3>
                    <p class="text-xl sm:text-2xl font-bold text-green-600 dark:text-green-400 mt-2">
                        Rp {{ number_format($metrics['total_income'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-green-100 dark:bg-green-800 flex items-center justify-center">
                    <i class="fas fa-arrow-up text-green-600 dark:text-green-400 text-lg sm:text-xl"></i>
                </div>
            </div>
            @if(isset($metrics['income_change']))
            <div class="mt-4 flex items-center text-sm {{ $metrics['income_change'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                <i class="fas fa-{{ $metrics['income_change'] >= 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                {{ abs($metrics['income_change']) }}% from last {{ $analysisType === 'monthly' ? 'month' : 'year' }}
            </div>
            @endif
        </div>

        <div class="card bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900 dark:to-red-800 rounded-lg shadow-lg p-4 sm:p-6 transform hover:scale-105 transition-transform duration-200" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-medium">Total Expenses</h3>
                    <p class="text-xl sm:text-2xl font-bold text-red-600 dark:text-red-400 mt-2">
                        Rp {{ number_format($metrics['total_expenses'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-red-100 dark:bg-red-800 flex items-center justify-center">
                    <i class="fas fa-arrow-down text-red-600 dark:text-red-400 text-lg sm:text-xl"></i>
                </div>
            </div>
            @if(isset($metrics['expense_change']))
            <div class="mt-4 flex items-center text-sm {{ $metrics['expense_change'] <= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                <i class="fas fa-{{ $metrics['expense_change'] <= 0 ? 'arrow-down' : 'arrow-up' }} mr-1"></i>
                {{ abs($metrics['expense_change']) }}% from last {{ $analysisType === 'monthly' ? 'month' : 'year' }}
            </div>
            @endif
        </div>

        <div class="card bg-gradient-to-br {{ $metrics['net_income'] >= 0 ? 'from-emerald-50 to-emerald-100 dark:from-emerald-900 dark:to-emerald-800' : 'from-red-50 to-red-100 dark:from-red-900 dark:to-red-800' }} rounded-lg shadow-lg p-4 sm:p-6 transform hover:scale-105 transition-transform duration-200" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-medium">Net Income</h3>
                    <p class="text-xl sm:text-2xl font-bold {{ $metrics['net_income'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} mt-2">
                        Rp {{ number_format($metrics['net_income'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full {{ $metrics['net_income'] >= 0 ? 'bg-emerald-100 dark:bg-emerald-800' : 'bg-red-100 dark:bg-red-800' }} flex items-center justify-center">
                    <i class="fas fa-{{ $metrics['net_income'] >= 0 ? 'chart-line' : 'exclamation-triangle' }} {{ $metrics['net_income'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} text-lg sm:text-xl"></i>
                </div>
            </div>
            @if(isset($metrics['net_income_change']))
            <div class="mt-4 flex items-center text-sm {{ $metrics['net_income_change'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                <i class="fas fa-{{ $metrics['net_income_change'] >= 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                {{ abs($metrics['net_income_change']) }}% from last {{ $analysisType === 'monthly' ? 'month' : 'year' }}
            </div>
            @endif
        </div>
    </div>

    <!-- Visualization: Key Financial Ratios Radar Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <i class="fas fa-bullseye mr-2"></i>Key Financial Ratios
        </h2>
        <div class="chart-container" id="ratiosChartContainer">
            <canvas id="ratiosRadarChart"></canvas>
        </div>
    </div>

    <!-- AI Analysis -->
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 sm:p-6" data-aos="fade-up" data-aos-delay="400">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">
                <i class="fas fa-robot text-indigo-600 dark:text-indigo-400 mr-2"></i>
                AI Financial Analysis
            </h3>
            <span class="px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 whitespace-nowrap">
                <i class="fas fa-bolt mr-1"></i>
                Powered by AI
            </span>
        </div>
        <div class="prose dark:prose-invert max-w-none">
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-sm sm:text-base">{{ $analysis->analysis_summary }}</p>
            
            @if(!empty($analysis->recommendations))
            <div class="mt-6 sm:mt-8 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/50 dark:to-emerald-900/50 rounded-lg p-4 sm:p-6">
                <h4 class="font-bold text-gray-900 dark:text-white flex items-center text-base sm:text-lg">
                    <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                    Recommendations
                </h4>
                <ul class="mt-4 space-y-3">
                    @foreach($analysis->recommendations as $recommendation)
                    <li class="flex items-start bg-white dark:bg-gray-800 rounded-lg p-3 sm:p-4 shadow-sm">
                        <div class="flex-shrink-0 w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center mr-3">
                            <i class="fas fa-check text-green-600 dark:text-green-400 text-sm sm:text-base"></i>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300 text-sm sm:text-base">{{ $recommendation }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(!empty($analysis->related_resources))
            <div class="mt-6 sm:mt-8">
                <h4 class="font-bold text-gray-900 dark:text-white flex items-center text-base sm:text-lg">
                    <i class="fas fa-book text-indigo-500 mr-2"></i>
                    Related Resources
                </h4>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    @foreach($analysis->related_resources as $resource)
                    <a href="{{ $resource['url'] }}" 
                       class="flex items-center p-3 sm:p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full {{ $resource['type'] === 'article' ? 'bg-blue-100 dark:bg-blue-900' : 'bg-purple-100 dark:bg-purple-900' }} flex items-center justify-center mr-3 sm:mr-4">
                            <i class="fas fa-{{ $resource['type'] === 'article' ? 'newspaper' : 'video' }} {{ $resource['type'] === 'article' ? 'text-blue-600 dark:text-blue-400' : 'text-purple-600 dark:text-purple-400' }} text-sm sm:text-base"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h5 class="font-medium text-gray-900 dark:text-white text-sm sm:text-base truncate">{{ $resource['title'] }}</h5>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $resource['type'] === 'article' ? 'Article' : 'Video' }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Category Distribution Chart -->
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 sm:p-6" data-aos="fade-up" data-aos-delay="500">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">
                <i class="fas fa-chart-pie text-indigo-600 dark:text-indigo-400 mr-2"></i>
                Category Distribution
            </h3>
        </div>
        <div class="chart-container" id="categoryChartContainer">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <!-- Historical Analyses -->
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 sm:p-6" data-aos="fade-up" data-aos-delay="600">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">
                <i class="fas fa-history text-indigo-600 dark:text-indigo-400 mr-2"></i>
                Historical Analyses
            </h3>
            <div class="flex items-center space-x-2">
                <select class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="all">All Time</option>
                    <option value="month">Last Month</option>
                    <option value="year">Last Year</option>
                </select>
            </div>
        </div>
        <div class="space-y-3 sm:space-y-4">
            @foreach($historicalAnalyses as $historicalAnalysis)
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 sm:p-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                <div class="flex flex-wrap justify-between items-start gap-3">
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $historicalAnalysis->analysis_type === 'monthly' 
                                    ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' 
                                    : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' }}">
                                <i class="fas fa-{{ $historicalAnalysis->analysis_type === 'monthly' ? 'calendar-alt' : 'calendar' }} mr-1"></i>
                                {{ ucfirst($historicalAnalysis->analysis_type) }}
                            </span>
                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                <i class="far fa-clock mr-1"></i>
                                {{ $historicalAnalysis->created_at->format('d M Y H:i') }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm sm:text-base text-gray-700 dark:text-gray-300 line-clamp-2">{{ $historicalAnalysis->analysis_summary }}</p>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Wait for both DOM and window load to ensure all resources are available
window.addEventListener('load', function() {
    // Initialize content wrapper
    const contentWrapper = document.querySelector('.content-wrapper');
    if (contentWrapper) {
        contentWrapper.classList.add('loaded');
    }
    // Initialize charts after a small delay
    setTimeout(initializeCharts, 50);
});

function initializeCharts() {
    const categoryData = @json($categoryData);
    const metrics = @json($metrics);
    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? '#E5E7EB' : '#374151';
    const gridColor = isDarkMode ? '#374151' : '#E5E7EB';

    // Initialize category chart
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryData.map(item => item.category_name),
                datasets: [{
                    data: categoryData.map(item => item.total),
                    backgroundColor: categoryData.map(item => item.color),
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
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                return `${context.label}: Rp ${value.toLocaleString('id-ID')}`;
                            }
                        }
                    }
                }
            }
        });

        // Mark category chart container as loaded
        const categoryContainer = document.getElementById('categoryChartContainer');
        if (categoryContainer) {
            categoryContainer.classList.add('loaded');
        }
    }

    // Initialize ratios radar chart
    const ratiosCtx = document.getElementById('ratiosRadarChart');
    if (ratiosCtx) {
        const ratiosRadarChart = new Chart(ratiosCtx, {
            type: 'radar',
            data: {
                labels: ['Cash Flow Ratio', 'Operating Margin', 'Growth Rate', 'Profitability Index'],
                datasets: [{
                    label: 'Current Period',
                    data: [
                        metrics.cash_flow_ratio ?? 0,
                        metrics.operating_margin ?? 0,
                        metrics.growth_rate ?? 0,
                        metrics.profitability_index ?? 0
                    ],
                    backgroundColor: isDarkMode ? 'rgba(79, 70, 229, 0.2)' : 'rgba(79, 70, 229, 0.2)',
                    borderColor: '#4F46E5',
                    pointBackgroundColor: '#4F46E5',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#4F46E5'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { 
                            color: textColor,
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        backgroundColor: isDarkMode ? '#1F2937' : '#FFFFFF',
                        titleColor: textColor,
                        bodyColor: textColor,
                        borderColor: isDarkMode ? '#374151' : '#E5E7EB',
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const metricName = context.label;
                                const rawValue = metrics.raw_metrics[metricName.toLowerCase().replace(/\s+/g, '_')];
                                return `${metricName}: ${value.toFixed(1)}% (Raw: ${rawValue.toFixed(1)}%)`;
                            }
                        }
                    }
                },
                scales: {
                    r: {
                        angleLines: { color: gridColor, lineWidth: 1 },
                        grid: { color: gridColor, lineWidth: 1 },
                        pointLabels: { 
                            color: textColor,
                            font: { size: 12, weight: '500' }
                        },
                        ticks: { 
                            color: textColor,
                            backdropColor: 'transparent',
                            z: 1,
                            stepSize: 20,
                            callback: function(value) { return value + '%'; }
                        },
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            }
        });

        // Mark ratios chart container as loaded
        const ratiosContainer = document.getElementById('ratiosChartContainer');
        if (ratiosContainer) {
            ratiosContainer.classList.add('loaded');
        }
    }

    // Handle window resize with debouncing
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            const charts = Chart.instances;
            for (let i = 0; i < charts.length; i++) {
                charts[i].resize();
            }
        }, 100);
    });

    // Mark containers as loaded after initialization
    const container = document.getElementById('chartContainer');
    if (container) {
        container.classList.add('loaded');
    }
}
</script>
@endpush 