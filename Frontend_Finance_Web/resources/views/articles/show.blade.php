@extends('layouts.app')

@section('title', $article->title . ' - Finapp')

@section('content')
<div class="mx-auto max-w-3xl">
    <a href="{{ route('articles.index') }}" class="mb-5 inline-flex min-h-11 items-center gap-2 text-callout font-medium text-fg-muted transition-colors hover:text-fg">
        <x-icon name="arrow-left" class="size-4" />Kembali ke artikel
    </a>

    <article class="space-y-6">
        <x-card padding="none">
            @if ($article->image_url)
                <img src="{{ $article->image_url }}" alt="" class="h-56 w-full object-cover sm:h-80">
            @endif
            <div class="p-6 sm:p-8">
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                    <x-badge tone="accent">{{ $article->category->name ?? 'Umum' }}</x-badge>
                    <span class="flex items-center gap-1.5 text-footnote text-fg-muted"><x-icon name="clock" class="size-3.5" />{{ $article->reading_time }} menit baca</span>
                </div>
                <h1 class="mt-4 text-title text-fg sm:text-largetitle">{{ $article->title }}</h1>
                <p class="mt-3 text-callout text-fg-muted">
                    Oleh <span class="font-medium text-fg">{{ $article->author }}</span> ·
                    {{ $article->created_at->locale('id')->translatedFormat('d F Y') }}
                </p>

                @if ($article->tags)
                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach ($article->tags as $tag)
                            <a href="{{ route('articles.index', ['tag' => $tag]) }}" class="inline-flex min-h-9 items-center rounded-full bg-surface-muted px-3.5 text-footnote font-medium text-fg-muted transition-colors hover:text-fg">#{{ $tag }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-card>

        <x-card padding="lg">
            <div class="article-body">{!! $article->content !!}</div>
        </x-card>

        @if ($relatedArticles->isNotEmpty())
            <section aria-labelledby="related-title" class="pt-2">
                <h2 id="related-title" class="mb-4 text-title text-fg">Artikel terkait</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ($relatedArticles as $related)
                        <x-card as="a" interactive :href="route('articles.show', $related)" class="block p-5">
                            <div class="flex items-center justify-between gap-3">
                                <x-badge tone="accent">{{ $related->category->name ?? 'Umum' }}</x-badge>
                                <span class="text-footnote text-fg-muted">{{ $related->reading_time }} menit baca</span>
                            </div>
                            <h3 class="mt-3 line-clamp-2 text-headline text-fg">{{ $related->title }}</h3>
                            <p class="mt-1.5 line-clamp-2 text-callout text-fg-muted">{{ Str::limit(strip_tags($related->content), 100) }}</p>
                        </x-card>
                    @endforeach
                </div>
            </section>
        @endif

        <div class="flex items-center justify-between gap-3 pt-2">
            <x-button :href="route('articles.index')" variant="secondary" icon="arrow-left">Semua artikel</x-button>
            <x-button variant="soft" icon="arrow-up-right" onclick="shareArticle()">Bagikan</x-button>
        </div>
    </article>
</div>
@endsection

@push('scripts')
<script>
async function shareArticle() {
    const data = { title: @js($article->title), text: 'Baca artikel ini di Finapp', url: window.location.href };
    if (navigator.share) {
        try { await navigator.share(data); } catch (e) { /* dibatalkan pengguna */ }
        return;
    }
    try {
        await navigator.clipboard.writeText(data.url);
        window.Finapp.toast('Tautan disalin ke clipboard', 'success');
    } catch (e) {
        window.Finapp.toast('Tautan tidak bisa disalin. Salin dari bilah alamat.', 'error');
    }
}
</script>
@endpush
