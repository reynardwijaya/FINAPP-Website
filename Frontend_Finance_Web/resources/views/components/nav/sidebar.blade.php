{{-- Sidebar desktop (≥ lg): panel glass melayang dengan sudut membulat. Di layar kecil digantikan bottom tab bar. --}}
@props(['items', 'secondary' => []])
<aside class="fixed inset-y-3 left-3 z-40 hidden w-64 flex-col overflow-hidden rounded-sheet chrome lg:flex">
    <a href="{{ route('dashboard') }}" class="flex h-16 items-center px-6" aria-label="Finapp, ke Beranda">
        <x-logo chrome />
    </a>
    <nav class="flex flex-1 flex-col justify-between overflow-y-auto px-3 pb-3 pt-2" aria-label="Navigasi utama">
        <div class="space-y-1">
            @foreach ($items as $item)
                <x-nav.item :href="$item['href']" :icon="$item['icon']" :label="$item['label']" :active="$item['active']" />
            @endforeach
        </div>
        <div class="space-y-1 border-t border-chrome-line pt-3">
            @foreach ($secondary as $item)
                <x-nav.item :href="$item['href']" :icon="$item['icon']" :label="$item['label']" :active="$item['active']" />
            @endforeach
        </div>
    </nav>
</aside>
