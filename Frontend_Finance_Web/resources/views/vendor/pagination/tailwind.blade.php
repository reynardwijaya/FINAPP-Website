{{-- Pagination bergaya Finapp (menggantikan view bawaan Laravel). Teks Bahasa Indonesia. --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman" class="flex flex-col items-center gap-3 sm:flex-row sm:justify-between">
        <p class="text-footnote text-fg-muted">
            Menampilkan <span class="font-medium text-fg">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</span>
            dari <span class="font-medium text-fg">{{ $paginator->total() }}</span> data
        </p>

        @php
            $btn = 'inline-flex size-11 items-center justify-center rounded-control text-callout font-medium transition-colors';
        @endphp
        <div class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <span class="{{ $btn }} cursor-not-allowed text-fg-subtle opacity-50" aria-disabled="true" aria-label="Halaman sebelumnya"><x-icon name="chevron-left" /></span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $btn }} text-fg-muted hover:bg-surface-muted hover:text-fg" aria-label="Halaman sebelumnya"><x-icon name="chevron-left" /></a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="{{ $btn }} hidden text-fg-subtle sm:inline-flex" aria-hidden="true">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="{{ $btn }} bg-accent-soft text-accent" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="{{ $btn }} hidden text-fg-muted hover:bg-surface-muted hover:text-fg sm:inline-flex" aria-label="Ke halaman {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $btn }} text-fg-muted hover:bg-surface-muted hover:text-fg" aria-label="Halaman berikutnya"><x-icon name="chevron-right" /></a>
            @else
                <span class="{{ $btn }} cursor-not-allowed text-fg-subtle opacity-50" aria-disabled="true" aria-label="Halaman berikutnya"><x-icon name="chevron-right" /></span>
            @endif
        </div>
    </nav>
@endif
