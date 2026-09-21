@extends('layouts.app')

@section('title', 'Laporan - Finapp')

@section('content')
@php
    $income = $transactions->where('type', 'income')->sum('amount');
    $expense = $transactions->where('type', 'expense')->sum('amount');
    $net = $income - $expense;
    $rate = $income > 0 ? ($net / $income) * 100 : 0;
    $rp = fn ($n) => ($n < 0 ? '−' : '').'Rp '.number_format(abs($n), 0, ',', '.');
    $filtered = request()->hasAny(['start_date', 'end_date', 'type', 'category_id']);
@endphp

<x-page-header title="Laporan" subtitle="Saring transaksi berdasarkan tanggal dan jenis untuk melihat ringkasannya." />

<div class="space-y-6">
    {{-- Filter (GET, query string sama dengan sebelumnya) --}}
    <x-card>
        <form method="GET" action="{{ route('reports.index') }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:items-end">
            <x-input name="start_date" type="date" label="Dari tanggal" :value="request('start_date')" />
            <x-input name="end_date" type="date" label="Sampai tanggal" :value="request('end_date')" />
            <x-select name="type" label="Jenis">
                <option value="">Semua jenis</option>
                <option value="income" @selected(request('type') === 'income')>Pemasukan</option>
                <option value="expense" @selected(request('type') === 'expense')>Pengeluaran</option>
            </x-select>
            <div class="flex gap-3">
                <x-button type="submit" icon="search" class="flex-1">Terapkan</x-button>
                @if ($filtered)
                    <x-button :href="route('reports.index')" variant="secondary">Atur ulang</x-button>
                @endif
            </div>
        </form>
    </x-card>

    {{-- Ringkasan: dihitung dari transaksi yang tampil di halaman ini --}}
    <section aria-label="Ringkasan laporan" class="space-y-3">
        <p class="text-footnote text-fg-muted">Ringkasan dari {{ $transactions->count() }} transaksi di halaman ini.</p>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-stat label="Pemasukan" icon="arrow-up-right" tone="success" :value="$rp($income)" />
            <x-stat label="Pengeluaran" icon="arrow-down-left" tone="danger" :value="$rp($expense)" />
            <x-stat label="Selisih" icon="wallet" tone="accent" :value="$rp($net)" hint="Pemasukan dikurangi pengeluaran" />
            <x-stat label="Sisa dari pemasukan" icon="percent" tone="warning" :value="number_format($rate, 1, ',', '.').'%'" />
        </div>
    </section>

    <x-card padding="none" title="Daftar transaksi">
        @if ($transactions->isEmpty())
            <x-empty-state icon="search" title="Tidak ada transaksi yang cocok"
                           :description="$filtered ? 'Coba ubah rentang tanggal atau jenis transaksi.' : 'Catat transaksi untuk mulai melihat laporan.'">
                @if ($filtered)
                    <x-button :href="route('reports.index')" variant="secondary">Atur ulang filter</x-button>
                @else
                    <x-button :href="route('transactions.create')" icon="plus">Catat transaksi</x-button>
                @endif
            </x-empty-state>
        @else
            <div class="divide-y divide-line px-5 md:hidden">
                @foreach ($transactions as $transaction)
                    <x-transaction-item :transaction="$transaction" />
                @endforeach
            </div>
            <x-table class="hidden md:block">
                <thead>
                    <tr><th>Tanggal</th><th>Jenis</th><th>Kategori</th><th>Deskripsi</th><th class="text-right">Jumlah</th></tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td class="whitespace-nowrap text-fg-muted">{{ $transaction->transaction_date?->locale('id')->translatedFormat('d M Y') ?? '-' }}</td>
                            <td><x-transaction-type :type="$transaction->type" /></td>
                            <td>
                                @if ($transaction->category)
                                    <span class="inline-flex items-center gap-2">
                                        <span class="size-2.5 rounded-full" style="background-color: {{ $transaction->category->color }}"></span>{{ $transaction->category->name }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="max-w-64 truncate text-fg-muted">{{ $transaction->description ?? '-' }}</td>
                            <td class="text-right"><x-amount :value="$transaction->amount" :type="$transaction->type" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>
            @if ($transactions->hasPages())
                <div class="border-t border-line px-5 py-4 sm:px-6">{{ $transactions->appends(request()->query())->links() }}</div>
            @endif
        @endif
    </x-card>
</div>
@endsection
