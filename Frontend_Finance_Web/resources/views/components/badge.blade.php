{{-- Lencana status. tone: neutral | accent | success | danger | warning | info. Selalu sertakan teks, jangan hanya warna. --}}
@props(['tone' => 'neutral', 'icon' => null])
@php
    $tones = [
        'neutral' => 'bg-surface-muted text-fg-muted',
        'accent' => 'bg-accent-soft text-accent',
        'success' => 'bg-success-soft text-success-fg',
        'danger' => 'bg-danger-soft text-danger-fg',
        'warning' => 'bg-warning-soft text-warning-fg',
        'info' => 'bg-info-soft text-info-fg',
    ];
@endphp
<span {{ $attributes->class(['inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-caption font-medium whitespace-nowrap', $tones[$tone] ?? $tones['neutral']]) }}>
    @if ($icon)<x-icon :name="$icon" class="size-3.5" />@endif
    {{ $slot }}
</span>
