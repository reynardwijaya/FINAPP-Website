@extends('layouts.app')

@section('title', 'Articles - Finapp')

@section('header', 'Financial Articles')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6" data-aos="fade-up">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Financial Articles & Resources</h1>
                <p class="text-gray-600 dark:text-gray-300 mb-6">Explore the latest articles and resources to help you manage your finances better.</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" 
                           placeholder="Search articles..." 
                           class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <select class="rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Visualization: Articles per Category -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <i class="fas fa-chart-bar mr-2"></i>Articles per Category
        </h2>
        <div class="relative" style="height: 300px;">
            <canvas id="articlesCategoryChart"></canvas>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($articles as $article)
        <article class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover-scale" data-aos="fade-up">
            @if($article->image_url)
                <img src="{{ $article->image_url }}" 
                     alt="{{ $article->title }}" 
                     class="w-full h-48 object-cover">
            @endif
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                        {{ $article->category->name ?? 'Uncategorized' }}
                    </span>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-clock mr-1"></i>
                        {{ $article->reading_time }} min read
                    </div>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
                    {{ $article->title }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                    {{ Str::limit(strip_tags($article->content), 150) }}
                </p>
                @if($article->tags)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($article->formatted_tags as $tag)
                            <a href="{{ route('articles.index', ['tag' => $tag['slug']]) }}" 
                               class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                #{{ $tag['name'] }}
                            </a>
                        @endforeach
                    </div>
                @endif
                <div class="flex items-center justify-between">
                    <a href="{{ route('articles.show', $article) }}" 
                       class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                        Read More
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $article->created_at->format('d M Y') }}
                    </span>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-8">
        {{ $articles->links() }}
    </div>
</div>

@push('scripts')
<script>
// Store chart instance globally to prevent multiple instances
let articlesCategoryChart = null;

// Function to initialize the chart
function initializeArticlesChart() {
    const chartCanvas = document.getElementById('articlesCategoryChart');
    if (!chartCanvas) return;

    // If chart already exists, destroy it
    if (articlesCategoryChart) {
        articlesCategoryChart.destroy();
        articlesCategoryChart = null;
    }

    const ctx = chartCanvas.getContext('2d');
    const currentTheme = getCurrentTheme();
    const theme = themeColors[currentTheme];

    // Create new chart instance
    articlesCategoryChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($categories->pluck('name')) !!},
            datasets: [{
                label: 'Articles',
                data: {!! json_encode($categories->pluck('articles_count')) !!},
                backgroundColor: theme.chart.category1,
                borderColor: theme.chart.category1,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 0 // Disable animations to prevent container issues
            },
            plugins: {
                legend: { 
                    display: false 
                },
                tooltip: {
                    backgroundColor: theme.tooltip.background,
                    titleColor: theme.tooltip.text,
                    bodyColor: theme.tooltip.text,
                    borderColor: theme.tooltip.border,
                    borderWidth: 1,
                    padding: 12
                }
            },
            scales: {
                x: {
                    grid: { 
                        display: false // Hide x-axis grid lines
                    },
                    ticks: { 
                        color: theme.text.secondary,
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    grid: { 
                        color: theme.grid.primary,
                        drawBorder: false
                    },
                    ticks: { 
                        color: theme.text.secondary,
                        beginAtZero: true,
                        precision: 0 // Only show whole numbers
                    }
                }
            }
        }
    });
}

// Wait for both DOM and window load to ensure all resources are available
window.addEventListener('load', function() {
    // Initialize search and category filter
    const searchInput = document.querySelector('input[type="text"]');
    const categorySelect = document.querySelector('select');

    // Debounce function for search
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Search functionality
    const handleSearch = debounce((value) => {
        window.location.href = "{{ route('articles.index') }}?search=" + encodeURIComponent(value);
    }, 300);

    searchInput.addEventListener('input', (e) => {
        handleSearch(e.target.value);
    });

    // Category filter
    categorySelect.addEventListener('change', (e) => {
        window.location.href = "{{ route('articles.index') }}?category=" + encodeURIComponent(e.target.value);
    });

    // Initialize chart after a small delay to ensure DOM is ready
    setTimeout(initializeArticlesChart, 100);

    // Theme change handler
    document.addEventListener('themeChanged', function() {
        if (!articlesCategoryChart) return;
        
        const newTheme = getCurrentTheme();
        const newThemeColors = themeColors[newTheme];
        
        // Update chart colors
        articlesCategoryChart.data.datasets[0].backgroundColor = newThemeColors.chart.category1;
        articlesCategoryChart.data.datasets[0].borderColor = newThemeColors.chart.category1;
        
        // Update tooltip colors
        articlesCategoryChart.options.plugins.tooltip.backgroundColor = newThemeColors.tooltip.background;
        articlesCategoryChart.options.plugins.tooltip.titleColor = newThemeColors.tooltip.text;
        articlesCategoryChart.options.plugins.tooltip.bodyColor = newThemeColors.tooltip.text;
        articlesCategoryChart.options.plugins.tooltip.borderColor = newThemeColors.tooltip.border;
        
        // Update axis colors
        articlesCategoryChart.options.scales.x.ticks.color = newThemeColors.text.secondary;
        articlesCategoryChart.options.scales.y.grid.color = newThemeColors.grid.primary;
        articlesCategoryChart.options.scales.y.ticks.color = newThemeColors.text.secondary;
        
        articlesCategoryChart.update('none'); // Update without animation
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (articlesCategoryChart) {
            articlesCategoryChart.destroy();
            articlesCategoryChart = null;
        }
    });
});

// Cleanup on page hide
document.addEventListener('visibilitychange', function() {
    if (document.hidden && articlesCategoryChart) {
        articlesCategoryChart.destroy();
        articlesCategoryChart = null;
    } else if (!document.hidden && !articlesCategoryChart) {
        setTimeout(initializeArticlesChart, 100);
    }
});
</script>
@endpush
@endsection 