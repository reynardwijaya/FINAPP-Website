{{--
    Kartu. padding: md | lg | none (none = tabel/daftar yang rapat ke tepi).
    Slot `action` = tombol/link di kanan judul. interactive = efek hover untuk kartu yang bisa diklik.
--}}
@props(['title' => null, 'subtitle' => null, 'padding' => 'md', 'as' => 'div', 'interactive' => false])
@php
    $pad = ['md' => 'p-5 sm:p-6', 'lg' => 'p-6 sm:p-8', 'none' => ''][$padding] ?? 'p-5 sm:p-6';
    $headPad = $padding === 'none' ? 'border-b border-line px-5 py-4 sm:px-6' : 'px-5 pt-5 sm:px-6 sm:pt-6';
    $bodyPad = $padding === 'none' ? '' : ($title || isset($action) ? 'px-5 pb-5 pt-4 sm:px-6 sm:pb-6' : $pad);
@endphp
<{{ $as }} {{ $attributes->class([
    'glass flex flex-col overflow-hidden rounded-card',
    'transition-[box-shadow,border-color,transform] hover:-translate-y-0.5 hover:border-line-strong' => $interactive,
]) }}>
    @if ($title || isset($action))
        <div class="flex items-start justify-between gap-4 {{ $headPad }}">
            <div class="min-w-0">
                @if ($title)<h2 class="text-headline text-fg">{{ $title }}</h2>@endif
                @if ($subtitle)<p class="mt-0.5 text-footnote text-fg-muted">{{ $subtitle }}</p>@endif
            </div>
            @isset($action)<div class="shrink-0">{{ $action }}</div>@endisset
        </div>
    @endif
    <div class="flex flex-1 flex-col {{ $bodyPad }}">{{ $slot }}</div>
</{{ $as }}>
