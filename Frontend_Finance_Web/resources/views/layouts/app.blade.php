<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body>
    @php
        $navItems = [
            ['label' => 'Beranda', 'icon' => 'layout-dashboard', 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard')],
            ['label' => 'Transaksi', 'icon' => 'arrow-left-right', 'href' => route('transactions.index'), 'active' => request()->routeIs('transactions.*')],
            ['label' => 'Laporan', 'icon' => 'file-text', 'href' => route('reports.index'), 'active' => request()->routeIs('reports.*')],
            ['label' => 'Analisis', 'icon' => 'bar-chart', 'href' => route('analysis.index'), 'active' => request()->routeIs('analysis.*')],
            ['label' => 'Artikel', 'icon' => 'newspaper', 'href' => route('articles.index'), 'active' => request()->routeIs('articles.*')],
        ];
        $navSecondary = [
            ['label' => 'Kategori', 'icon' => 'tag', 'href' => route('categories.index'), 'active' => request()->routeIs('categories.*')],
            ['label' => 'Pengaturan', 'icon' => 'settings', 'href' => route('settings.index'), 'active' => request()->routeIs('settings.*')],
        ];
    @endphp

    <a href="#main" class="sr-only rounded-control bg-primary px-4 py-2 text-on-primary focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[80]">Lewati ke konten</a>

    <x-nav.sidebar :items="$navItems" :secondary="$navSecondary" />

    <div class="flex min-h-dvh flex-col lg:pl-72">
        <x-nav.topbar :secondary="$navSecondary" />
        <main id="main" class="mx-auto w-full max-w-6xl flex-1 px-4 pb-32 pt-6 sm:px-6 lg:px-8 lg:pb-10 lg:pt-4">
            @yield('content')
        </main>
    </div>

    <x-nav.tabbar :items="$navItems" />
    <x-flash />

    @stack('scripts')
</body>
</html>
