@props(['name', 'label' => null])
@php
    $icons = cache()->driver('array')->rememberForever('finapp.icons', fn () => require resource_path('views/icons.php'));
    $shape = $icons[$name] ?? $icons['circle'];
@endphp
<svg {{ $attributes->merge(['class' => 'size-5 shrink-0']) }}
     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
     @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" focusable="false" @endif>{!! $shape !!}</svg>
