{{-- Pembungkus label + pesan bantuan/kesalahan untuk kontrol form. Error diambil dari $errors berdasarkan `name`. --}}
@props(['label' => null, 'name' => null, 'hint' => null, 'optional' => false, 'for' => null, 'bag' => null])
@php
    $id = $for ?? $name;
    $error = $name ? ($bag ?? $errors)->first($name) : null;
@endphp
<div {{ $attributes->class('space-y-1.5') }}>
    @if ($label)
        <label for="{{ $id }}" class="block text-callout font-medium text-fg">
            {{ $label }}@if ($optional) <span class="font-normal text-fg-subtle">(opsional)</span>@endif
        </label>
    @endif
    {{ $slot }}
    @if ($error)
        <p id="{{ $id }}-error" class="flex items-start gap-1.5 text-footnote text-danger-fg">
            <x-icon name="alert-circle" class="mt-px size-4" />{{ $error }}
        </p>
    @elseif ($hint)
        <p id="{{ $id }}-hint" class="text-footnote text-fg-muted">{{ $hint }}</p>
    @endif
</div>
