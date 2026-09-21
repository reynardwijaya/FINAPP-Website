{{-- Avatar pengguna: foto profil (accessor profile_picture_url) atau inisial. --}}
@props(['user' => null, 'size' => 'size-9', 'chrome' => false])
@php
    $name = $user->username ?? '';
    $photo = $user?->profile_picture_url;
    $initial = mb_strtoupper(mb_substr($name !== '' ? $name : '?', 0, 1));
@endphp
@if ($photo)
    <img src="{{ $photo }}" alt="" {{ $attributes->class([$size, 'shrink-0 rounded-full object-cover']) }}>
@else
    <span aria-hidden="true" {{ $attributes->class([$size, 'grid shrink-0 place-items-center rounded-full text-callout font-semibold', $chrome ? 'bg-chrome-active text-chrome-fg' : 'bg-accent-soft text-accent']) }}>{{ $initial }}</span>
@endif
