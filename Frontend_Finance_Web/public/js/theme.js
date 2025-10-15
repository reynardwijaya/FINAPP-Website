// Theme color configuration
const themeColors = {
    light: {
        // Base colors
        text: {
            primary: '#1F2937',
            secondary: '#4B5563',
            muted: '#6B7280',
            inverse: '#FFFFFF'
        },
        background: {
            primary: '#FFFFFF',
            secondary: '#F9FAFB',
            card: '#FFFFFF',
            gradient: {
                start: 'rgba(255, 255, 255, 0.9)',
                end: 'rgba(255, 255, 255, 0.7)'
            }
        },
        border: {
            light: '#E5E7EB',
            medium: '#D1D5DB',
            dark: '#9CA3AF'
        },
        grid: {
            primary: '#E5E7EB',
            secondary: '#F3F4F6'
        },
        chart: {
            income: ['#059669', '#10B981', '#34D399', '#6EE7B7', '#A7F3D0'],
            expense: ['#DC2626', '#EF4444', '#F87171', '#FCA5A5', '#FECACA'],
            neutral: ['#6B7280', '#9CA3AF', '#D1D5DB', '#E5E7EB', '#F3F4F6'],
            accent: ['#3B82F6', '#60A5FA', '#93C5FD', '#BFDBFE', '#DBEAFE'],
            category1: '#059669',  // Green
            category2: '#3B82F6',  // Blue
            category3: '#F59E0B',  // Amber
            category4: '#8B5CF6',  // Purple
            category5: '#EC4899',  // Pink
            category6: '#10B981'   // Emerald
        },
        tooltip: {
            background: '#FFFFFF',
            border: '#E5E7EB',
            text: '#1F2937'
        },
        shadow: {
            sm: '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
            md: '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
            lg: '0 10px 15px -3px rgba(0, 0, 0, 0.1)'
        }
    },
    dark: {
        // Base colors
        text: {
            primary: '#F9FAFB',
            secondary: '#E5E7EB',
            muted: '#9CA3AF',
            inverse: '#1F2937'
        },
        background: {
            primary: '#111827',
            secondary: '#1F2937',
            card: '#1F2937',
            gradient: {
                start: 'rgba(17, 24, 39, 0.9)',
                end: 'rgba(17, 24, 39, 0.7)'
            }
        },
        border: {
            light: '#374151',
            medium: '#4B5563',
            dark: '#6B7280'
        },
        grid: {
            primary: '#374151',
            secondary: '#1F2937'
        },
        chart: {
            income: ['#059669', '#10B981', '#34D399', '#6EE7B7', '#A7F3D0'],
            expense: ['#DC2626', '#EF4444', '#F87171', '#FCA5A5', '#FECACA'],
            neutral: ['#9CA3AF', '#6B7280', '#4B5563', '#374151', '#1F2937'],
            accent: ['#60A5FA', '#3B82F6', '#2563EB', '#1D4ED8', '#1E40AF'],
            category1: '#10B981',  // Emerald
            category2: '#60A5FA',  // Blue
            category3: '#FBBF24',  // Amber
            category4: '#A78BFA',  // Purple
            category5: '#F472B6',  // Pink
            category6: '#34D399'   // Green
        },
        tooltip: {
            background: '#1F2937',
            border: '#374151',
            text: '#F9FAFB'
        },
        shadow: {
            sm: '0 1px 2px 0 rgba(0, 0, 0, 0.3)',
            md: '0 4px 6px -1px rgba(0, 0, 0, 0.4)',
            lg: '0 10px 15px -3px rgba(0, 0, 0, 0.4)'
        }
    }
};

// Function to get current theme
function getCurrentTheme() {
    return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
}

// Function to toggle theme
function toggleTheme() {
    const html = document.documentElement;
    html.classList.toggle('dark');
    localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
    updateChartColors();
}

// Make functions globally accessible
window.getCurrentTheme = getCurrentTheme;
window.toggleTheme = toggleTheme;
window.updateChartColors = updateChartColors;

// Function to apply theme-dependent styles
function applyThemeDependentStyles() {
    updateChartColors();
}

// Function to update chart colors
function updateChartColors() {
    const theme = getCurrentTheme();
    const colors = themeColors[theme];
    
    // Common chart options
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 750,
            easing: 'easeInOutQuart'
        },
        plugins: {
            legend: {
                labels: {
                    color: colors.text.primary,
                    font: {
                        size: 12,
                        family: "'Inter', sans-serif"
                    },
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: colors.tooltip.background,
                titleColor: colors.tooltip.text,
                bodyColor: colors.tooltip.text,
                borderColor: colors.tooltip.border,
                borderWidth: 1,
                padding: 12,
                cornerRadius: 8,
                displayColors: true,
                usePointStyle: true,
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw || 0;
                        const prefix = context.dataset.type === 'percentage' ? '' : 'Rp ';
                        const suffix = context.dataset.type === 'percentage' ? '%' : '';
                        return `${label}: ${prefix}${value.toLocaleString('id-ID')}${suffix}`;
                    }
                }
            }
        }
    };

    // Safely update charts if Chart.js is available
    if (typeof Chart !== 'undefined' && Chart.registry && Chart.registry.instances) {
        Object.values(Chart.registry.instances).forEach(chart => {
            // Update chart options
            chart.options.plugins.legend.labels.color = colors.text.primary;
            chart.options.plugins.tooltip.backgroundColor = colors.tooltip.background;
            chart.options.plugins.tooltip.titleColor = colors.tooltip.text;
            chart.options.plugins.tooltip.bodyColor = colors.tooltip.text;
            chart.options.plugins.tooltip.borderColor = colors.tooltip.border;

            // Update scales if they exist
            if (chart.options.scales) {
                if (chart.options.scales.x) {
                    chart.options.scales.x.grid.color = colors.grid.primary;
                    chart.options.scales.x.grid.borderColor = colors.grid.primary;
                    chart.options.scales.x.ticks.color = colors.text.secondary;
                    chart.options.scales.x.border.color = colors.border.light;
                }
                if (chart.options.scales.y) {
                    chart.options.scales.y.grid.color = colors.grid.primary;
                    chart.options.scales.y.grid.borderColor = colors.grid.primary;
                    chart.options.scales.y.ticks.color = colors.text.secondary;
                    chart.options.scales.y.border.color = colors.border.light;
                }
            }

            // Update dataset colors based on chart type
            if (chart.config.type === 'doughnut') {
                chart.data.datasets.forEach(dataset => {
                    dataset.borderColor = colors.background.primary;
                    dataset.backgroundColor = dataset.label.toLowerCase().includes('income') 
                        ? colors.chart.income 
                        : colors.chart.expense;
                });
            } else if (chart.config.type === 'bar') {
                chart.data.datasets.forEach(dataset => {
                    dataset.backgroundColor = dataset.label.toLowerCase().includes('income')
                        ? colors.chart.income[0]
                        : colors.chart.expense[0];
                    dataset.borderColor = colors.background.primary;
                });
            } else if (chart.config.type === 'line') {
                chart.data.datasets.forEach(dataset => {
                    const colorIndex = dataset.label.toLowerCase().includes('income') ? 0 : 1;
                    dataset.borderColor = dataset.label.toLowerCase().includes('savings')
                        ? colors.chart.accent[colorIndex]
                        : dataset.label.toLowerCase().includes('income')
                            ? colors.chart.income[colorIndex]
                            : colors.chart.expense[colorIndex];
                    dataset.backgroundColor = dataset.borderColor + '20'; // Add transparency
                });
            }

            chart.update('none'); // Update without animation for theme changes
        });
    }
}

// Initialize theme system
document.addEventListener('DOMContentLoaded', function() {
    // Wait for Chart.js to be fully loaded
    const waitForChart = setInterval(() => {
        if (typeof Chart !== 'undefined' && Chart.registry) {
            clearInterval(waitForChart);
            // Listen for theme changes with debounce
            let themeChangeTimeout;
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class') {
                        clearTimeout(themeChangeTimeout);
                        themeChangeTimeout = setTimeout(() => {
                            updateChartColors();
                        }, 100); // Debounce theme changes
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });

            // Initial theme application
            updateChartColors();
        }
    }, 100); // Check every 100ms

    // Clear interval after 5 seconds to prevent infinite checking
    setTimeout(() => clearInterval(waitForChart), 5000);
}); 