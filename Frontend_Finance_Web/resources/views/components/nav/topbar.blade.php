{{-- Top bar: panel glass melayang. Mobile: selebar layar dengan logo di kiri. Desktop: pil kecil di pojok kanan atas (tema + akun). --}}
@props(['secondary' => []])
@php $user = auth()->user(); @endphp
<div class="pointer-events-none sticky top-0 z-30 mx-auto w-full max-w-6xl px-4 pt-3 sm:px-6 lg:flex lg:justify-end lg:px-8">
<header class="chrome pointer-events-auto flex h-14 items-center justify-between gap-2 rounded-card pl-4 pr-2 lg:h-12 lg:justify-end lg:rounded-full lg:pl-2">
    <a href="{{ route('dashboard') }}" class="lg:hidden" aria-label="Finapp, ke Beranda"><x-logo chrome /></a>

    <div class="flex items-center gap-1">
        <x-theme-toggle chrome />
        <x-dropdown width="w-64">
            <x-slot:trigger>
                <button type="button" aria-haspopup="menu" aria-label="Menu akun {{ $user->username }}"
                        class="flex min-h-11 items-center gap-2 rounded-full py-1 pl-1 pr-2 transition-colors hover:bg-chrome-hover sm:pr-3">
                    <x-avatar :user="$user" chrome />
                    <span class="hidden max-w-32 truncate text-callout font-medium text-chrome-fg sm:block">{{ $user->username }}</span>
                    <x-icon name="chevron-down" class="hidden size-4 text-chrome-fg-muted sm:block" />
                </button>
            </x-slot:trigger>

            <div class="px-3 pb-2 pt-1.5">
                <p class="truncate text-callout font-medium text-fg">{{ $user->username }}</p>
                <p class="truncate text-footnote text-fg-muted">{{ $user->email }}</p>
            </div>
            <div class="my-1 border-t border-line"></div>
            <x-dropdown-item :href="route('profile.show')" icon="user">Profil saya</x-dropdown-item>
            @foreach ($secondary as $item)
                <x-dropdown-item :href="$item['href']" :icon="$item['icon']" class="lg:hidden">{{ $item['label'] }}</x-dropdown-item>
            @endforeach
            <div class="my-1 border-t border-line"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-item type="submit" icon="log-out" :danger="true">Keluar</x-dropdown-item>
            </form>
        </x-dropdown>
    </div>
</header>
</div>
