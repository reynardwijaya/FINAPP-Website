@extends('layouts.app')

@section('title', 'Analisis - Finapp')

@section('content')
@php
    $periodLabel = $analysisType === 'monthly' ? 'bulan ini' : 'tahun ini';
    $rp = fn ($n) => ($n < 0 ? '−' : '').'Rp '.number_format(abs($n), 0, ',', '.');
    $isEmpty = ($metrics['total_income'] + $metrics['total_expenses']) == 0;
    $ratios = [
        ['key' => 'cash_flow_ratio', 'label' => 'Arus kas', 'hint' => 'Perbandingan uang masuk dan keluar.'],
        ['key' => 'operating_margin', 'label' => 'Margin usaha', 'hint' => 'Bagian pemasukan yang menjadi keuntungan.'],
        ['key' => 'growth_rate', 'label' => 'Pertumbuhan', 'hint' => 'Perubahan keuntungan dibanding periode lalu.'],
        ['key' => 'profitability_index', 'label' => 'Keuntungan', 'hint' => 'Seberapa besar keuntungan dari pemasukan.'],
    ];
    $typeLabel = ['monthly' => 'Bulanan', 'yearly' => 'Tahunan'];
@endphp

<x-page-header title="Analisis" :subtitle="'Kondisi keuangan usahamu '.$periodLabel.', dengan saran yang bisa langsung dicoba.'">
    <span data-period>
        <x-segmented label="Periode analisis" :items="[
            ['label' => 'Bulanan', 'icon' => 'calendar', 'href' => route('analysis.index', ['type' => 'monthly']), 'active' => $analysisType === 'monthly'],
            ['label' => 'Tahunan', 'icon' => 'calendar', 'href' => route('analysis.index', ['type' => 'yearly']), 'active' => $analysisType === 'yearly'],
        ]" />
    </span>
</x-page-header>

{{-- Saat periode diganti, konten diredupkan agar jelas sedang dimuat dan tidak bisa diklik dua kali --}}
<div x-data="{ loading: false }" @click="if ($event.target.closest('[data-period] a')) loading = true"
     @pageshow.window="loading = false"
     :class="loading && 'pointer-events-none opacity-60'" :aria-busy="loading" class="space-y-6 transition-opacity">

    @if ($isEmpty)
        <x-alert type="info" title="Belum ada transaksi {{ $periodLabel }}">
            Catat pemasukan dan pengeluaran dulu, lalu analisis dan saran akan muncul di sini.
            <a href="{{ route('transactions.create') }}" class="font-medium underline underline-offset-2">Catat transaksi</a>
        </x-alert>
    @endif

    {{-- Ringkasan --}}
    <section aria-label="Ringkasan periode" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="Pemasukan" icon="arrow-up-right" tone="success" :value="$rp($metrics['total_income'])" />
        <x-stat label="Pengeluaran" icon="arrow-down-left" tone="danger" :value="$rp($metrics['total_expenses'])" />
        <x-stat label="Keuntungan bersih" icon="wallet" :tone="$metrics['net_income'] >= 0 ? 'accent' : 'danger'" :value="$rp($metrics['net_income'])"
                :hint="$metrics['net_income'] >= 0 ? 'Usahamu untung.' : 'Pengeluaran lebih besar dari pemasukan.'" />
        <x-stat label="Porsi pengeluaran" icon="percent" tone="warning" :value="number_format($metrics['expense_ratio'], 1, ',', '.').'%'"
                :hint="'Dari tiap Rp100 pemasukan, Rp'.(int) round($metrics['expense_ratio']).' dipakai untuk pengeluaran.'" />
    </section>

    {{-- Analisis otomatis + rekomendasi --}}
    <x-card title="Analisis otomatis" subtitle="Disusun dari data transaksimu dengan aturan sederhana">
        <x-slot:action><x-badge tone="accent" icon="sparkles">Otomatis</x-badge></x-slot:action>
        <p class="text-body leading-relaxed text-fg-muted">{{ $analysis->analysis_summary }}</p>

        @if (! empty($analysis->recommendations))
            <div class="mt-6">
                <h3 class="flex items-center gap-2 text-headline text-fg"><x-icon name="lightbulb" class="text-warning-fg" />Saran untukmu</h3>
                <ul class="mt-3 space-y-2.5">
                    @foreach ($analysis->recommendations as $recommendation)
                        <li class="flex items-start gap-3 rounded-control bg-surface-muted/70 p-4">
                            <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-success-soft text-success-fg"><x-icon name="check" class="size-3.5" /></span>
                            <span class="text-callout text-fg">{{ $recommendation }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6">
            <x-button :href="route('articles.index')" variant="secondary" icon="book-open">Baca artikel edukasi</x-button>
        </div>
    </x-card>

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Kesehatan keuangan --}}
        <x-card title="Kesehatan keuangan" subtitle="Makin luas area, makin sehat">
            <div class="relative h-72" data-chart-wrap>
                <x-skeleton class="absolute inset-0" data-skeleton />
                <canvas id="ratiosRadarChart" role="img" aria-label="Grafik radar empat indikator kesehatan keuangan"></canvas>
            </div>
            <dl class="mt-5 space-y-3">
                @foreach ($ratios as $r)
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <dt class="text-callout font-medium text-fg">{{ $r['label'] }}</dt>
                            <dd class="text-footnote text-fg-muted">{{ $r['hint'] }}</dd>
                        </div>
                        <span class="num shrink-0 text-callout font-medium text-fg">{{ number_format($metrics[$r['key']] ?? 0, 0, ',', '.') }}%</span>
                    </div>
                @endforeach
            </dl>
        </x-card>

        {{-- Pembagian kategori --}}
        <x-card title="Pembagian per kategori" :subtitle="'Total transaksi '.$periodLabel">
            @if (count($categoryData) > 0)
                <div class="relative h-72" data-chart-wrap>
                    <x-skeleton class="absolute inset-0" data-skeleton />
                    <canvas id="categoryChart" role="img" aria-label="Grafik donat pembagian transaksi per kategori"></canvas>
                </div>
            @else
                <x-empty-state icon="inbox" title="Belum ada data kategori" description="Grafik muncul setelah ada transaksi pada periode ini." />
            @endif
        </x-card>
    </div>

    {{-- Riwayat analisis --}}
    <x-card title="Riwayat analisis" subtitle="5 analisis terakhir">
        @if ($historicalAnalyses->isEmpty())
            <x-empty-state icon="clock" title="Belum ada riwayat" description="Riwayat akan tersimpan setiap kali analisis dibuat." />
        @else
            <ul class="divide-y divide-line">
                @foreach ($historicalAnalyses as $item)
                    <li class="py-4 first:pt-0 last:pb-0">
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                            <x-badge :tone="$item->analysis_type === 'monthly' ? 'info' : 'accent'" icon="calendar">{{ $typeLabel[$item->analysis_type] ?? ucfirst($item->analysis_type) }}</x-badge>
                            <span class="flex items-center gap-1.5 text-footnote text-fg-muted">
                                <x-icon name="clock" class="size-3.5" />{{ $item->created_at->locale('id')->translatedFormat('d M Y, H:i') }}
                            </span>
                        </div>
                        <p class="mt-2 line-clamp-2 text-callout text-fg-muted">{{ $item->analysis_summary }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-card>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const { charts } = window.Finapp;
    const metrics = @js($metrics);
    const categoryData = @js($categoryData);
    const ready = (canvas) => canvas.closest('[data-chart-wrap]')?.querySelector('[data-skeleton]')?.remove();

    // Radar kesehatan keuangan. Kunci raw_metrics tetap sama seperti sebelumnya.
    const ratios = @js(collect($ratios)->map(fn ($r) => ['key' => $r['key'], 'label' => $r['label']])->values());
    const radar = document.getElementById('ratiosRadarChart');
    if (radar) {
        charts.create(radar, (t) => ({
            type: 'radar',
            data: {
                labels: ratios.map(r => r.label),
                datasets: [{
                    label: 'Periode ini',
                    data: ratios.map(r => Number(metrics[r.key] ?? 0)),
                    backgroundColor: charts.withAlpha(t.primary, 0.18),
                    borderColor: t.primary, borderWidth: 2,
                    pointBackgroundColor: t.primary, pointBorderColor: t.surface, pointRadius: 4,
                }],
            },
            options: {
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: (ctx) => {
                        const raw = Number(metrics.raw_metrics?.[ratios[ctx.dataIndex].key] ?? 0);
                        return `${ctx.label}: ${ctx.parsed.r.toFixed(1)}% (nilai asli ${raw.toFixed(1)}%)`;
                    } } },
                },
                scales: { r: {
                    suggestedMin: 0, suggestedMax: 100,
                    angleLines: { color: t.grid }, grid: { color: t.grid },
                    pointLabels: { color: t.tick, font: { family: t.font, size: 12 } },
                    ticks: { color: t.tick, backdropColor: 'transparent', stepSize: 25, callback: (v) => v + '%' },
                } },
            },
        }));
        ready(radar);
    }

    // Donat kategori (warna kategori dari data pengguna)
    const donut = document.getElementById('categoryChart');
    if (donut) {
        charts.create(donut, (t) => ({
            type: 'doughnut',
            data: {
                labels: categoryData.map(c => c.category_name),
                datasets: [{ data: categoryData.map(c => Number(c.total)), backgroundColor: categoryData.map(c => c.color), borderColor: t.surface, borderWidth: 3, hoverOffset: 6 }],
            },
            options: { cutout: '68%', plugins: { legend: { position: 'bottom' } } },
        }));
        ready(donut);
    }
});
</script>
@endpush
