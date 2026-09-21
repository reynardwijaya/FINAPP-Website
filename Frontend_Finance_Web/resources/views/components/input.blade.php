{{-- Input teks. `value` diisi otomatis dari old(); atribut lain (type, placeholder, autocomplete, dst.) diteruskan ke <input>. --}}
@props(['name', 'label' => null, 'hint' => null, 'optional' => false, 'prefix' => null, 'value' => null, 'type' => 'text', 'wrapperClass' => ''])
@php
    $id = $attributes->get('id', $name);
    $hasError = $errors->has($name);
    $describedBy = $hasError ? $id.'-error' : ($hint ? $id.'-hint' : null);
    $control = 'block w-full min-h-11 rounded-control border bg-surface/70 backdrop-blur-sm focus:bg-surface px-3.5 text-body text-fg placeholder:text-fg-subtle '
        .'transition-[border-color,box-shadow] focus:outline-none focus:ring-[3px] disabled:opacity-60 '
        .($hasError ? 'border-danger focus:border-danger focus:ring-danger/25' : 'border-line-strong focus:border-ring focus:ring-ring/25');
@endphp
<x-field :label="$label" :name="$name" :for="$id" :hint="$hint" :optional="$optional" :class="$wrapperClass">
    <div class="relative">
        @if ($prefix)
            <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-callout text-fg-subtle">{{ $prefix }}</span>
        @endif
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
               @if ($type !== 'password' && $type !== 'file') value="{{ old($name, $value) }}" @endif
               @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
               @if ($hasError) aria-invalid="true" @endif
               {{ $attributes->except('id')->merge(['class' => $control.($prefix ? ' pl-11' : '')]) }}>
    </div>
</x-field>
