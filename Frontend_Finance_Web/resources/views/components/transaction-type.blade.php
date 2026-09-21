{{-- Lencana jenis transaksi (income | expense): warna + ikon panah + label teks. --}}
@props(['type'])
@if ($type === 'income')
    <x-badge tone="success" icon="arrow-up-right" {{ $attributes }}>Pemasukan</x-badge>
@else
    <x-badge tone="danger" icon="arrow-down-left" {{ $attributes }}>Pengeluaran</x-badge>
@endif
