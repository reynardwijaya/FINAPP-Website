{{-- Select. Isi <option> lewat slot; gunakan `selected` di option seperti biasa. --}}
@props(['name', 'label' => null, 'hint' => null, 'optional' => false, 'wrapperClass' => ''])
@php
    $id = $attributes->get('id', $name);
    $hasError = $errors->has($name);
    $describedBy = $hasError ? $id.'-error' : ($hint ? $id.'-hint' : null);
    $control = 'block w-full min-h-11 appearance-none rounded-control border bg-surface/70 backdrop-blur-sm focus:bg-surface pl-3.5 pr-10 text-body text-fg '
        .'transition-[border-color,box-shadow] focus:outline-none focus:ring-[3px] disabled:opacity-60 '
        .($hasError ? 'border-danger focus:border-danger focus:ring-danger/25' : 'border-line-strong focus:border-ring focus:ring-ring/25');
@endphp
<x-field :label="$label" :name="$name" :for="$id" :hint="$hint" :optional="$optional" :class="$wrapperClass">
    <div class="relative">
        <select name="{{ $name }}" id="{{ $id }}"
                @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
                @if ($hasError) aria-invalid="true" @endif
                {{ $attributes->except('id')->merge(['class' => $control]) }}>{{ $slot }}</select>
        <x-icon name="chevron-down" class="pointer-events-none absolute right-3.5 top-1/2 size-4 -translate-y-1/2 text-fg-subtle" />
    </div>
</x-field>
