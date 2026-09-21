{{-- Banner inline. type: info | success | warning | danger. Slot = isi (boleh daftar). --}}
@props(['type' => 'info', 'title' => null])
@php
    $tone = [
        'info' => ['bg-info-soft text-info-fg', 'info'],
        'success' => ['bg-success-soft text-success-fg', 'check-circle'],
        'warning' => ['bg-warning-soft text-warning-fg', 'alert-triangle'],
        'danger' => ['bg-danger-soft text-danger-fg', 'alert-circle'],
    ][$type] ?? ['bg-info-soft text-info-fg', 'info'];
@endphp
<div role="{{ $type === 'danger' ? 'alert' : 'status' }}" {{ $attributes->class(['flex gap-3 rounded-card p-4 text-callout', $tone[0]]) }}>
    <x-icon :name="$tone[1]" class="mt-0.5 size-5" />
    <div class="min-w-0 space-y-1">
        @if ($title)<p class="font-medium">{{ $title }}</p>@endif
        <div>{{ $slot }}</div>
    </div>
</div>
