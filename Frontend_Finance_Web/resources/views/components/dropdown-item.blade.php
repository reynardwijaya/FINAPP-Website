{{-- Item menu dropdown. Dengan `href` menjadi tautan, tanpa `href` menjadi tombol (mis. di dalam form logout). --}}
@props(['href' => null, 'icon' => null, 'danger' => false, 'active' => false])
@php
    $classes = 'flex w-full min-h-11 items-center gap-3 rounded-[0.7rem] px-3 text-left text-callout transition-colors '
        .($danger ? 'text-danger-fg hover:bg-danger-soft' : ($active ? 'bg-accent-soft text-accent' : 'text-fg hover:bg-surface-muted'));
@endphp
@if ($href)
    <a href="{{ $href }}" role="menuitem" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<x-icon :name="$icon" class="size-[1.125rem] {{ $danger ? '' : 'text-fg-muted' }}" />@endif{{ $slot }}
    </a>
@else
    <button type="{{ $attributes->get('type', 'button') }}" role="menuitem" {{ $attributes->except('type')->merge(['class' => $classes]) }}>
        @if ($icon)<x-icon :name="$icon" class="size-[1.125rem] {{ $danger ? '' : 'text-fg-muted' }}" />@endif{{ $slot }}
    </button>
@endif
