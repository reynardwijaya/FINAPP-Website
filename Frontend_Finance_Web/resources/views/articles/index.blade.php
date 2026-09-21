@extends('layouts.app')

@section('title', 'Artikel - Finapp')

@section('content')
@php
    $activeTag = request('tag');
    $hasFilter = request()->hasAny(['search', 'tag', 'category']);
@endphp

<x-page-header title="Artikel" subtitle="Bacaan singkat untuk membantu mengelola keuangan usaha kecil." />

<div class="space-y-6">
    {{-- Cari & saring (GET; query string search / tag / category sama seperti sebelumnya) --}}
    <x-card>
        <form method="GET" action="{{ route('articles.index') }}" class="flex flex-col gap-3 sm:flex-row">
            <div class="relative flex-1">
                <label for="search" class="sr-only">Cari artikel</label>
                <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-[1.125rem] -translate-y-1/2 text-fg-subtle" />
                <input type="search" id="search" name="search" value="{{ request('search') }}" placeholder="Cari judul, isi, atau penulis"
                       class="block min-h-11 w-full rounded-control border border-line-strong bg-surface/70 pl-10 pr-3.5 text-body text-fg backdrop-blur-sm placeholder:text-fg-subtle focus:border-ring focus:bg-surface focus:outline-none focus:ring-[3px] focus:ring-ring/25">
            </div>
            @if ($categories->isNotEmpty())
                <div class="relative sm:w-56">
                    <label for="category" class="sr-only">Kategori</label>
                    <select id="category" name="category" onchange="this.form.requestSubmit()"
                            class="block min-h-11 w-full appearance-none rounded-control border border-line-strong bg-surface/70 pl-3.5 pr-10 text-body text-fg backdrop-blur-sm focus:border-ring focus:outline-none focus:ring-[3px] focus:ring-ring/25">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') == $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <x-icon name="chevron-down" class="pointer-events-none absolute right-3.5 top-1/2 size-4 -translate-y-1/2 text-fg-subtle" />
                </div>
            @endif
            @if ($activeTag)<input type="hidden" name="tag" value="{{ $activeTag }}">@endif
            <x-button type="submit" icon="search">Cari</x-button>
        </form>

        @if ($allTags->isNotEmpty())
            <div class="-mx-1 mt-4 flex gap-2 overflow-x-auto px-1 pb-1" role="group" aria-label="Saring berdasarkan topik">
                <a href="{{ route('articles.index', array_filter(['search' => request('search')])) }}"
                   class="inline-flex min-h-9 shrink-0 items-center rounded-full px-3.5 text-footnote font-medium transition-colors {{ $activeTag ? 'bg-surface-muted text-fg-muted hover:text-fg' : 'bg-accent-soft text-accent' }}">Semua</a>
                @foreach ($allTags as $tag)
                    <a href="{{ route('articles.index', array_filter(['tag' => $tag, 'search' => request('search')])) }}"
                       @if ($activeTag === $tag) aria-current="true" @endif
                       class="inline-flex min-h-9 shrink-0 items-center rounded-full px-3.5 text-footnote font-medium transition-colors {{ $activeTag === $tag ? 'bg-accent-soft text-accent' : 'bg-surface-muted text-fg-muted hover:text-fg' }}">#{{ $tag }}</a>
                @endforeach
            </div>
        @endif
    </x-card>

    @if ($categories->isNotEmpty())
        <x-card title="Jumlah artikel per kategori">
            <div class="h-64"><canvas id="articlesCategoryChart" role="img" aria-label="Grafik batang jumlah artikel per kategori"></canvas></div>
        </x-card>
    @endif

    {{-- Daftar artikel --}}
    @if ($articles->isEmpty())
        <x-card>
            <x-empty-state icon="newspaper" :title="$hasFilter ? 'Artikel tidak ditemukan' : 'Belum ada artikel'"
                           :description="$hasFilter ? 'Coba kata kunci atau topik lain.' : 'Artikel akan muncul di sini setelah diterbitkan.'">
                @if ($hasFilter)<x-button :href="route('articles.index')" variant="secondary">Tampilkan semua artikel</x-button>@endif
            </x-empty-state>
        </x-card>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($articles as $article)
                <x-card as="article" padding="none" interactive class="animate-enter relative">
                    @if ($article->image_url)
                        <img src="{{ $article->image_url }}" alt="" loading="lazy" class="h-44 w-full object-cover">
                    @endif
                    <div class="flex flex-1 flex-col p-5 sm:p-6">
                        <div class="flex items-center justify-between gap-3">
                            <x-badge tone="accent">{{ $article->category->name ?? 'Umum' }}</x-badge>
                            <span class="flex items-center gap-1.5 text-footnote text-fg-muted"><x-icon name="clock" class="size-3.5" />{{ $article->reading_time }} menit baca</span>
                        </div>
                        <h2 class="mt-4 line-clamp-2 text-headline text-fg">
                            <a href="{{ route('articles.show', $article) }}" class="after:absolute after:inset-0 hover:text-accent">{{ $article->title }}</a>
                        </h2>
                        <p class="mt-2 line-clamp-3 text-callout text-fg-muted">{{ Str::limit(strip_tags($article->content), 150) }}</p>
                        <div class="mt-auto flex items-center justify-between gap-3 pt-5 text-footnote text-fg-muted">
                            <span>{{ $article->created_at->locale('id')->translatedFormat('d M Y') }}</span>
                            <span class="inline-flex items-center gap-1 font-medium text-accent">Baca<x-icon name="arrow-right" class="size-4" /></span>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>

        @if ($articles->hasPages())
            <div>{{ $articles->appends(request()->query())->links() }}</div>
        @endif
    @endif
</div>
@endsection

@if ($categories->isNotEmpty())
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const { charts } = window.Finapp;
    const labels = @js($categories->pluck('name'));
    const counts = @js($categories->pluck('articles_count'));
    charts.create('articlesCategoryChart', (t) => ({
        type: 'bar',
        data: { labels, datasets: [{ label: 'Artikel', data: counts, backgroundColor: t.primary, borderRadius: 8, maxBarThickness: 40 }] },
        options: {
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: (c) => `${c.parsed.y} artikel` } } },
            scales: { ...charts.axes(t, { currency: false }), y: { ...charts.axes(t, { currency: false }).y, ticks: { ...charts.axes(t).y.ticks, precision: 0, callback: (v) => v } } },
        },
    }));
});
</script>
@endpush
@endif
