@extends('layouts.app')

@section('title', 'Beranda - Finapp')

@section('content')
@php
    $bulan = now()->locale('id')->translatedFormat('F Y');
    $sisaPerSeratus = (int) round(max(min($savingsRate, 100), 0));
    $trends = collect($monthlyTrends)->mapWithKeys(fn ($v, $k) => [
        \Carbon\Carbon::createFromFormat('!M Y', $k)->locale('id')->translatedFormat('M Y') => $v,
    ]);
    $hasTrend = $trends->sum(fn ($m) => $m['income'] + $m['expense']) > 0;
    $hasCategories = collect($categorySummary)->isNotEmpty();
    $noData = $recentTransactions->isEmpty();
@endphp

<x-page-header title="Beranda" :subtitle="'Ringkasan keuangan usahamu, '.$bulan.'.'">
    <x-button :href="route('transactions.create')" icon="plus">Catat transaksi</x-button>
</x-page-header>

<div class="space-y-6">
    {{-- Ringkasan --}}
    <section aria-label="Ringkasan bulan ini" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat hero class="animate-enter sm:col-span-2 lg:col-span-1" label="Saldo bulan ini"
                :value="($totalBalance < 0 ? '−' : '').'Rp '.number_format(abs($totalBalance), 0, ',', '.')" icon="wallet"
                hint="Pemasukan dikurangi pengeluaran" />
        <x-stat class="animate-enter" label="Pemasukan" icon="arrow-up-right" tone="success"
                :value="'Rp '.number_format($totalIncome, 0, ',', '.')" hint="Uang yang masuk bulan ini" />
        <x-stat class="animate-enter" label="Pengeluaran" icon="arrow-down-left" tone="danger"
                :value="'Rp '.number_format($totalExpenses, 0, ',', '.')" hint="Uang yang keluar bulan ini" />
        <x-stat class="animate-enter" label="Sisa dari pemasukan" icon="percent" tone="accent"
                :value="number_format($savingsRate, 1, ',', '.').'%'"
                :hint="$totalIncome > 0 ? 'Dari tiap Rp100 pemasukan, tersisa Rp'.$sisaPerSeratus.'.' : 'Belum ada pemasukan bulan ini.'" />
    </section>

    {{-- Grafik --}}
    <section class="grid gap-6 lg:grid-cols-5">
        <x-card class="lg:col-span-3" title="Tren 6 bulan terakhir" subtitle="Pemasukan dan pengeluaran per bulan">
            @if ($hasTrend)
                <div class="h-72">
                    <canvas id="monthlyTrendsChart" role="img" aria-label="Grafik garis pemasukan, pengeluaran, dan selisih selama 6 bulan terakhir"></canvas>
                </div>
            @else
                <x-empty-state icon="bar-chart" title="Belum ada data untuk grafik"
                               description="Grafik akan muncul setelah kamu mencatat transaksi." />
            @endif
        </x-card>

        <x-card class="lg:col-span-2" title="Ke mana uangnya?" subtitle="Per kategori, bulan ini"
                x-data="{ type: 'expense' }" x-effect="window.dispatchEvent(new CustomEvent('category-type', { detail: type }))">
            <x-slot:action>
                <x-segmented model="type" label="Jenis transaksi" :items="[
                    ['label' => 'Keluar', 'value' => 'expense'],
                    ['label' => 'Masuk', 'value' => 'income'],
                ]" />
            </x-slot:action>
            @if ($hasCategories)
                <div class="h-72">
                    <canvas id="categoryDistributionChart" role="img" aria-label="Grafik donat pembagian transaksi per kategori"></canvas>
                </div>
                <p id="categoryEmpty" class="hidden py-16 text-center text-callout text-fg-muted">Belum ada transaksi jenis ini bulan ini.</p>
            @else
                <x-empty-state icon="inbox" title="Belum ada transaksi bulan ini"
                               description="Catat transaksi pertamamu untuk melihat pembagian per kategori." />
            @endif
        </x-card>
    </section>

    {{-- Transaksi terbaru --}}
    <x-card padding="none" title="Transaksi terbaru">
        <x-slot:action>
            <x-button :href="route('transactions.index')" variant="ghost" size="sm" icon-right="chevron-right">Lihat semua</x-button>
        </x-slot:action>

        @if ($noData)
            <x-empty-state icon="wallet" title="Belum ada transaksi"
                           description="Mulai dengan mencatat pemasukan atau pengeluaran pertama usahamu.">
                <x-button :href="route('transactions.create')" icon="plus">Catat transaksi</x-button>
            </x-empty-state>
        @else
            {{-- Mobile: daftar kartu --}}
            <div class="divide-y divide-line px-5 md:hidden">
                @foreach ($recentTransactions as $transaction)
                    <x-transaction-item :transaction="$transaction" />
                @endforeach
            </div>
            {{-- Desktop: tabel --}}
            <x-table class="hidden md:block">
                <thead>
                    <tr><th>Tanggal</th><th>Kategori</th><th>Deskripsi</th><th>Jenis</th><th class="text-right">Jumlah</th></tr>
                </thead>
                <tbody>
                    @foreach ($recentTransactions as $transaction)
                        <tr>
                            <td class="whitespace-nowrap text-fg-muted">{{ $transaction->transaction_date?->locale('id')->translatedFormat('d M Y') ?? '-' }}</td>
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
                            <td><x-transaction-type :type="$transaction->type" /></td>
                            <td class="text-right"><x-amount :value="$transaction->amount" :type="$transaction->type" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>
        @endif
    </x-card>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const { charts } = window.Finapp;

    // Tren bulanan
    const trends = @js($trends);
    const months = Object.keys(trends);
    charts.create('monthlyTrendsChart', (t) => ({
        type: 'line',
        data: {
            labels: months,
            datasets: [
                { label: 'Pemasukan', data: months.map(m => Number(trends[m].income)), borderColor: t.income, backgroundColor: charts.withAlpha(t.income, 0.1), fill: true },
                { label: 'Pengeluaran', data: months.map(m => Number(trends[m].expense)), borderColor: t.expense, fill: false },
                { label: 'Selisih', data: months.map(m => Number(trends[m].net)), borderColor: t.net, borderDash: [5, 4], fill: false },
            ].map(d => ({ ...d, tension: 0.35, borderWidth: 2, pointRadius: 3, pointHoverRadius: 5, pointBackgroundColor: d.borderColor })),
        },
        options: { scales: charts.axes(t), plugins: { legend: { position: 'bottom' } } },
    }));

    // Distribusi kategori (warna kategori berasal dari data pengguna)
    const summary = @js($categorySummary);
    let type = 'expense';
    const canvas = document.getElementById('categoryDistributionChart');
    if (!canvas) return;
    const chart = charts.create(canvas, (t) => {
        const rows = summary.filter(r => r.type === type);
        return {
            type: 'doughnut',
            data: {
                labels: rows.map(r => r.category_name),
                datasets: [{ data: rows.map(r => Number(r.total)), backgroundColor: rows.map(r => r.category_color), borderColor: t.surface, borderWidth: 3, hoverOffset: 6 }],
            },
            options: { cutout: '68%', plugins: { legend: { position: 'bottom' } } },
        };
    });
    // Pilihan jenis disimpan Alpine di kartu (x-data) dan dikirim lewat event `category-type`.
    const empty = document.getElementById('categoryEmpty');
    const refresh = () => {
        const has = summary.some(r => r.type === type);
        canvas.parentElement.classList.toggle('hidden', !has);
        empty.classList.toggle('hidden', has);
        if (has) chart.rebuild();
    };
    window.addEventListener('category-type', (e) => { type = e.detail; refresh(); });
    refresh();
});
</script>
@endpush
