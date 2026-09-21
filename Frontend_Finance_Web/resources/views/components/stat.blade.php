{{--
    Kartu angka ringkas. tone: neutral | accent | success | danger | warning.
    hero = kartu utama (gradien ungu halus, angka besar); dipakai maksimal satu per layar.
    `value` sudah diformat oleh pemanggil (mis. "Rp 1.250.000").
--}}
@props(['label', 'value', 'icon' => null, 'tone' => 'neutral', 'hint' => null, 'hero' => false])
@php
    $chip = [
        'neutral' => 'bg-surface-muted text-fg-muted',
        'accent' => 'bg-accent-soft text-accent',
        'success' => 'bg-success-soft text-success-fg',
        'danger' => 'bg-danger-soft text-danger-fg',
        'warning' => 'bg-warning-soft text-warning-fg',
    ][$tone] ?? 'bg-surface-muted text-fg-muted';
    $wash = [
        'neutral' => 'from-surface-muted/60',
        'accent' => 'from-accent-soft',
        'success' => 'from-success-soft',
        'danger' => 'from-danger-soft',
        'warning' => 'from-warning-soft',
    ][$tone] ?? 'from-surface-muted/60';
@endphp
@if ($hero)
    <div {{ $attributes->class('rounded-card bg-gradient-to-br from-primary-600 to-primary-800 p-5 text-white shadow-raised sm:p-6') }}>
        <div class="flex items-center gap-2 text-footnote font-medium text-white/80">
            @if ($icon)<x-icon :name="$icon" class="size-4" />@endif{{ $label }}
        </div>
        <p class="num mt-3 text-largetitle font-semibold">{{ $value }}</p>
        @if ($hint)<p class="mt-1 text-footnote text-white/80">{{ $hint }}</p>@endif
        {{ $slot }}
    </div>
@else
    <div {{ $attributes->class(['glass rounded-card bg-gradient-to-br to-transparent p-5', $wash]) }}>
        <div class="flex items-center gap-2.5 text-footnote font-medium text-fg-muted">
            @if ($icon)
                <span class="grid size-8 place-items-center rounded-full {{ $chip }}"><x-icon :name="$icon" class="size-4" /></span>
            @endif
            {{ $label }}
        </div>
        <p class="num mt-3 text-title text-fg">{{ $value }}</p>
        @if ($hint)<p class="mt-1 text-footnote text-fg-muted">{{ $hint }}</p>@endif
        {{ $slot }}
    </div>
@endif
