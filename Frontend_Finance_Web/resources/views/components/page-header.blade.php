{{-- Judul halaman (large title). Slot = aksi utama halaman (satu tombol utama saja). --}}
@props(['title', 'subtitle' => null])
<header {{ $attributes->class('mb-6 flex flex-wrap items-end justify-between gap-x-6 gap-y-4 sm:mb-8') }}>
    <div class="min-w-0">
        <h1 class="text-title text-fg sm:text-largetitle">{{ $title }}</h1>
        @if ($subtitle)<p class="mt-1 text-callout text-fg-muted">{{ $subtitle }}</p>@endif
    </div>
    @if (! $slot->isEmpty())<div class="flex shrink-0 items-center gap-3">{{ $slot }}</div>@endif
</header>
