{{-- Satu item navigasi. variant: side (sidebar desktop) | tab (bottom tab bar mobile). --}}
@props(['href', 'icon', 'label', 'active' => false, 'variant' => 'side'])
@if ($variant === 'tab')
    <a href="{{ $href }}" @if ($active) aria-current="page" @endif
       class="flex min-h-14 flex-1 flex-col items-center justify-center gap-1 rounded-2xl px-1 text-caption font-medium transition-colors {{ $active ? 'bg-chrome-active text-chrome-active-fg' : 'text-chrome-fg-muted hover:text-chrome-fg' }}">
        <x-icon :name="$icon" class="size-6" />
        <span>{{ $label }}</span>
    </a>
@else
    <a href="{{ $href }}" @if ($active) aria-current="page" @endif
       class="flex min-h-11 items-center gap-3 rounded-control px-3 text-callout font-medium transition-colors {{ $active ? 'bg-chrome-active text-chrome-active-fg' : 'text-chrome-fg-muted hover:bg-chrome-hover hover:text-chrome-fg' }}">
        <x-icon :name="$icon" class="size-5" />
        {{ $label }}
    </a>
@endif
