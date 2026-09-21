{{-- Placeholder loading. Ikut token tema, jadi otomatis punya varian gelap. Atur ukuran lewat class (mis. h-4 w-1/2). --}}
@props(['circle' => false])
<div aria-hidden="true" {{ $attributes->class(['animate-shimmer bg-surface-muted', $circle ? 'rounded-full' : 'rounded-control']) }}></div>
