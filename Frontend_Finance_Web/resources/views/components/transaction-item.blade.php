{{--
    Satu transaksi sebagai baris kartu (dipakai di mobile sebagai pengganti tabel).
    Slot `actions` (opsional) = tombol aksi di sisi kanan bawah.
--}}
@props(['transaction'])
@php
    $category = $transaction->category;
    $date = $transaction->transaction_date?->locale('id')->translatedFormat('d M Y');
@endphp
<div {{ $attributes->class('flex items-center gap-3 py-3.5') }}>
    <span class="grid size-11 shrink-0 place-items-center rounded-full bg-surface-muted text-fg-muted">
        <x-category-icon :icon="$category->icon ?? null" class="size-5" />
    </span>
    <div class="min-w-0 flex-1">
        <p class="truncate text-callout font-medium text-fg">{{ $transaction->description ?: ($category->name ?? 'Tanpa deskripsi') }}</p>
        <p class="mt-0.5 flex items-center gap-1.5 truncate text-footnote text-fg-muted">
            @if ($category)
                {{-- warna kategori berasal dari data pengguna (satu-satunya inline style yang sah) --}}
                <span class="size-2 shrink-0 rounded-full" style="background-color: {{ $category->color }}"></span>{{ $category->name }} ·
            @endif
            {{ $date ?? '-' }}
        </p>
    </div>
    <div class="shrink-0 text-right">
        <x-amount :value="$transaction->amount" :type="$transaction->type" class="text-callout" />
        @isset($actions)<div class="mt-1">{{ $actions }}</div>@endisset
    </div>
</div>
