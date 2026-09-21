{{--
    Nominal Rupiah: "Rp 1.250.000". Bila `type` (income|expense) diberikan, ditambah tanda +/− dan warna semantik.
    Tanda dan teks pembaca layar selalu ada, jadi jenis transaksi tidak hanya dibedakan lewat warna.
--}}
@props(['value', 'type' => null])
@php
    $text = 'Rp '.number_format(abs((float) $value), 0, ',', '.');
    $tone = $type === 'income' ? 'text-success-fg' : ($type === 'expense' ? 'text-danger-fg' : 'text-fg');
@endphp
<span {{ $attributes->class(['num whitespace-nowrap font-medium', $tone]) }}>
    @if ($type)
        <span aria-hidden="true">{{ $type === 'income' ? '+' : '−' }}</span><span class="sr-only">{{ $type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</span>
    @elseif ($value < 0)
        <span aria-hidden="true">−</span><span class="sr-only">Minus</span>
    @endif
    {{ $text }}
</span>
