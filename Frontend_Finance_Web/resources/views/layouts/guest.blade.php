<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Finapp')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://kit.fontawesome.com/dfa213cb60.js" crossorigin="anonymous"></script>

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
         x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
         :class="{ 'dark': darkMode }">
        @yield('content')

        <!-- Theme Toggle Button -->
        <button @click="darkMode = !darkMode" 
                class="fixed bottom-4 right-4 p-3 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
            <i class="fas fa-sun text-yellow-500 dark:hidden"></i>
            <i class="fas fa-moon text-blue-300 hidden dark:block"></i>
        </button>
    </div>
</body>
</html> 