{{-- Checkbox dengan label; area sentuh penuh ≥44px. --}}
@props(['name', 'label', 'hint' => null, 'checked' => false, 'value' => '1'])
@php $id = $attributes->get('id', $name); @endphp
<label for="{{ $id }}" class="flex min-h-11 cursor-pointer items-start gap-3 py-2">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}" @checked(old($name, $checked))
           {{ $attributes->except('id')->merge(['class' => 'mt-0.5 size-5 shrink-0 rounded-md border-line-strong accent-primary']) }}>
    <span>
        <span class="block text-callout text-fg">{{ $label }}</span>
        @if ($hint)<span class="block text-footnote text-fg-muted">{{ $hint }}</span>@endif
    </span>
</label>
