{{--
    <head> bersama untuk semua layout (app, guest, welcome).
    Judul halaman: @section('title', '...') di view.
--}}
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="color-scheme" content="light dark">
<meta name="theme-color" content="#f5f3fd">
<title>@yield('title', 'Finapp')</title>
<link rel="icon" href="{{ asset('favicon.ico') }}">

{{-- Terapkan tema sebelum render pertama supaya tidak ada flash tema salah. Logika sama dengan resources/js/theme.js. --}}
<script>
    (function () {
        try {
            var t = localStorage.getItem('theme');
            var dark = t === 'dark' || (t !== 'light' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', dark);
            var m = document.querySelector('meta[name="theme-color"]');
            if (m) m.setAttribute('content', dark ? '#0e0c16' : '#f5f3fd');
        } catch (e) {}
    })();
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
