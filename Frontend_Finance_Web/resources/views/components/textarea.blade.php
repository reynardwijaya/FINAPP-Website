@props(['name', 'label' => null, 'hint' => null, 'optional' => false, 'value' => null, 'rows' => 4, 'wrapperClass' => ''])
@php
    $id = $attributes->get('id', $name);
    $hasError = $errors->has($name);
    $describedBy = $hasError ? $id.'-error' : ($hint ? $id.'-hint' : null);
    $control = 'block w-full rounded-control border bg-surface/70 backdrop-blur-sm focus:bg-surface px-3.5 py-3 text-body text-fg placeholder:text-fg-subtle '
        .'transition-[border-color,box-shadow] focus:outline-none focus:ring-[3px] disabled:opacity-60 '
        .($hasError ? 'border-danger focus:border-danger focus:ring-danger/25' : 'border-line-strong focus:border-ring focus:ring-ring/25');
@endphp
<x-field :label="$label" :name="$name" :for="$id" :hint="$hint" :optional="$optional" :class="$wrapperClass">
    <textarea name="{{ $name }}" id="{{ $id }}" rows="{{ $rows }}"
              @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
              @if ($hasError) aria-invalid="true" @endif
              {{ $attributes->except('id')->merge(['class' => $control]) }}>{{ old($name, $value) }}</textarea>
</x-field>
