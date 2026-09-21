<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body>
    <div class="fixed right-3 top-3 z-50">
        <x-theme-toggle />
    </div>

    @yield('content')

    <x-flash />
    @stack('scripts')
</body>
</html>
