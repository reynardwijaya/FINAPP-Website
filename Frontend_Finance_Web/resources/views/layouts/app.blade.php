<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Finapp') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
    @stack('scripts')
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }
        #app {
            height: 100vh;
            height: 100dvh;
        }
        .gradient-text {
            background: linear-gradient(45deg, #4F46E5, #7C3AED);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% 200%;
            animation: gradient-xy 15s ease infinite;
        }
        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .dark .glass-effect {
            background: rgba(17, 24, 39, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .nav-link {
            transition: all 0.3s ease;
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: currentColor;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
        }
        .dark .nav-link.active {
            background: rgba(255, 255, 255, 0.05);
        }
        .card {
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        .card:hover {
            border-color: #4F46E5;
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.1), 0 10px 10px -5px rgba(79, 70, 229, 0.04);
        }
        .dark .card:hover {
            border-color: #6366F1;
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.2), 0 10px 10px -5px rgba(99, 102, 241, 0.1);
        }
    </style>
    <script>
        // Set theme immediately to prevent FOUC
        (function() {
            const html = document.documentElement;
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        })();
    </script>
</head>
<body class="h-full bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
    <div id="app" class="h-full flex">
        <!-- Sidebar - Fixed width -->
        <aside class="w-64 bg-indigo-700 dark:bg-gray-800 text-white flex-shrink-0 h-full transition-colors duration-300">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between p-4 border-b border-indigo-600 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logoF-Photoroom.png') }}" alt="Finapp Logo" class="h-16 w-16">
                    <div>
                        <h2 class="text-2xl font-semibold gradient-text">Finapp</h2>
                    </div>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="h-[calc(100%-5rem)] overflow-y-auto flex flex-col justify-between">
                <div>
                    <a href="{{ route('dashboard') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('transactions.index') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        Transactions
                    </a>
                    <a href="{{ route('reports.index') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt mr-2"></i>
                        Reports
                    </a>
                    <a href="{{ route('analysis.index') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('analysis.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                        Analysis
                    </a>
                    <a href="{{ route('articles.index') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('articles.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper w-5 h-5 mr-3"></i>
                        Articles
                    </a>
                </div>
                <div class="pb-4">
                    <a href="{{ route('settings.index') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog w-5 h-5 mr-3"></i>
                        Settings
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Mobile menu button -->
        <div class="lg:hidden fixed top-0 left-0 z-40 w-full bg-indigo-700 dark:bg-gray-800 text-white p-4 transition-colors duration-300">
            <div class="flex items-center justify-between">
                <button type="button" class="text-white hover:text-indigo-200 focus:outline-none" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars h-6 w-6"></i>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="lg:hidden fixed inset-0 z-30 hidden">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75" onclick="toggleMobileMenu()"></div>
            <div class="fixed inset-y-0 left-0 flex flex-col w-64 bg-indigo-700 dark:bg-gray-800 text-white h-full transition-colors duration-300">
                <!-- Mobile menu header -->
                <div class="flex items-center justify-between p-4 border-b border-indigo-600 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logoF-Photoroom.png') }}" alt="Finapp Logo" class="h-16 w-16">
                        <div>
                            <h2 class="text-2xl font-semibold gradient-text">Finapp</h2>
                        </div>
                    </div>
                    <button type="button" class="text-white hover:text-indigo-200 focus:outline-none" onclick="toggleMobileMenu()">
                        <i class="fas fa-times h-6 w-6"></i>
                    </button>
                </div>

                <!-- Mobile menu navigation -->
                <nav class="flex-1 overflow-y-auto flex flex-col justify-between">
                    <div>
                        <a href="{{ route('dashboard') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('transactions.index') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                            <i class="fas fa-exchange-alt mr-2"></i>
                            Transactions
                        </a>
                        <a href="{{ route('reports.index') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt mr-2"></i>
                            Reports
                        </a>
                        <a href="{{ route('analysis.index') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('analysis.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                            Analysis
                        </a>
                        <a href="{{ route('articles.index') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('articles.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper w-5 h-5 mr-3"></i>
                            Articles
                        </a>
                    </div>
                    <div class="pb-4">
                        <a href="{{ route('settings.index') }}" class="nav-link flex items-center px-8 py-5 text-white hover:bg-indigo-600 dark:hover:bg-gray-700 {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                            <i class="fas fa-cog w-5 h-5 mr-3"></i>
                            Settings
                        </a>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main Content - Auto resize -->
        <div class="flex-1 flex flex-col min-w-0 h-full">
            <!-- Top Navigation -->
            <nav class="bg-white dark:bg-gray-800 shadow-lg flex-shrink-0 transition-colors duration-300">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center"> <!-- Added items-center for vertical alignment -->
                        <div class="flex items-center">
                            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">@yield('header', 'Dashboard')</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Profile Dropdown -->
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors focus:outline-none">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url ?? asset('images/default_profile.png') }}" alt="{{ Auth::user()->username }}" />
                                    <span class="ml-2 hidden md:block">{{ Auth::user()->username }}</span>
                                    <i class="fas fa-chevron-down ml-2 text-xs"></i>
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-user mr-2"></i> Profile
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
                <div class="h-full p-4 sm:p-6 lg:p-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM Content Loaded. Initializing theme and event listeners.');
            const html = document.documentElement;

            // Set initial height for mobile browsers
            function setFullHeight() {
                const vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', `${vh}px`);
            }
            setFullHeight();
            window.addEventListener('resize', setFullHeight);
            window.addEventListener('orientationchange', setFullHeight);

            // Ensure theme styles are applied to charts on page load and theme changes
            // Use window.onload to ensure Chart.js is fully loaded
            window.addEventListener('load', () => {
                console.log('Window loaded. Updating chart colors.');
                if (typeof window.updateChartColors === 'function') {
                    window.updateChartColors();
                } else {
                    console.log('window.updateChartColors is not defined.');
                }
            });

            // Observe changes to the 'class' attribute of the html element for theme changes
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class' && mutation.target === html) {
                        console.log('HTML class changed. Triggering chart color update.');
                        if (typeof window.updateChartColors === 'function') {
                            window.updateChartColors();
                        } else {
                            console.log('window.updateChartColors is not defined on mutation.');
                        }
                    }
                });
            });
            observer.observe(html, { attributes: true });

            // Initial chart color update for dynamically loaded charts (if any)
            document.querySelectorAll('canvas[id$="Chart"]').forEach(canvas => {
                if (Chart.getChart(canvas)) {
                    console.log('Found existing chart on DOMContentLoad. Updating colors.');
                    if (typeof window.updateChartColors === 'function') {
                        window.updateChartColors();
                    }
                }
            });
        });

        // Mobile menu toggle function
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }
    </script>
</body>
</html>