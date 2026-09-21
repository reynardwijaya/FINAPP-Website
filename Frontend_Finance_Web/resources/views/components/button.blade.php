{{--
    Tombol. variant: primary | secondary | soft | ghost | danger. size: sm | md | lg | icon.
    Tombol type="submit" otomatis nonaktif + spinner setelah form valid dikirim (cegah klik ganda).
    Tombol ikon saja WAJIB diberi aria-label.
--}}
@props(['variant' => 'primary', 'size' => 'md', 'href' => null, 'type' => 'button', 'icon' => null, 'iconRight' => null])
@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-control font-medium whitespace-nowrap select-none '
        .'transition-[background-color,color,box-shadow,transform,opacity] active:scale-[0.98] '
        .'disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50';
    $variants = [
        'primary' => 'bg-primary text-on-primary shadow-primary hover:bg-primary-hover',
        'secondary' => 'border border-line-strong bg-surface/60 text-fg backdrop-blur-md hover:bg-surface',
        'soft' => 'bg-accent-soft text-accent hover:brightness-95 dark:hover:brightness-125',
        'ghost' => 'text-fg-muted hover:bg-surface-muted hover:text-fg',
        'danger' => 'bg-danger-fg text-white hover:brightness-90 dark:bg-danger dark:text-canvas',
    ];
    $sizes = [
        'sm' => 'min-h-9 px-3 text-footnote max-md:min-h-11',
        'md' => 'min-h-11 px-4 text-callout',
        'lg' => 'min-h-12 px-6 text-body',
        'icon' => 'size-11',
    ];
    $classes = $base.' '.($variants[$variant] ?? $variants['primary']).' '.($sizes[$size] ?? $sizes['md']);
    $isSubmit = $type === 'submit' && ! $href;
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<x-icon :name="$icon" class="size-[1.125rem]" />@endif
        {{ $slot }}
        @if ($iconRight)<x-icon :name="$iconRight" class="size-[1.125rem]" />@endif
    </a>
@elseif ($isSubmit)
    <button type="submit" x-data="{ busy: false }" x-init="$el.form?.addEventListener('submit', () => busy = true)"
            @pageshow.window="busy = false" x-bind:disabled="busy" x-bind:aria-busy="busy"
            {{ $attributes->merge(['class' => $classes]) }}>
        <x-icon name="loader" class="size-[1.125rem] animate-spin" x-show="busy" x-cloak />
        @if ($icon)<x-icon :name="$icon" class="size-[1.125rem]" x-show="!busy" />@endif
        {{ $slot }}
    </button>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<x-icon :name="$icon" class="size-[1.125rem]" />@endif
        {{ $slot }}
        @if ($iconRight)<x-icon :name="$iconRight" class="size-[1.125rem]" />@endif
    </button>
@endif
