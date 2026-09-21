{{--
    Segmented control (gaya iOS). Dua mode:
      - Tautan:  items = [['label' => 'Bulanan', 'href' => '...', 'active' => true], ...]
      - Panel:   items = [['label' => 'Profil', 'value' => 'profile'], ...] + model="tab"
                 (nama variabel Alpine di parent; klik mengubah nilainya).
    Tiap item boleh punya 'icon'.
--}}
@props(['items' => [], 'model' => null, 'label' => null])
@php
    $on = 'bg-surface text-fg shadow-card';
    $off = 'text-fg-muted hover:text-fg';
    $itemBase = 'inline-flex min-h-10 flex-1 items-center justify-center gap-2 rounded-[0.55rem] px-3.5 text-callout font-medium whitespace-nowrap transition-[background-color,color,box-shadow]';
@endphp
<div {{ $attributes->class('inline-flex max-w-full gap-1 overflow-x-auto rounded-control bg-surface-muted/70 p-1 backdrop-blur-md') }}
     @if ($label) role="group" aria-label="{{ $label }}" @endif>
    @foreach ($items as $item)
        @if (isset($item['href']))
            <a href="{{ $item['href'] }}" class="{{ $itemBase }} {{ ! empty($item['active']) ? $on : $off }}"
               @if (! empty($item['active'])) aria-current="page" @endif>
                @isset($item['icon'])<x-icon :name="$item['icon']" class="size-4" />@endisset{{ $item['label'] }}
            </a>
        @else
            <button type="button" class="{{ $itemBase }}"
                    x-bind:class="{{ $model }} === '{{ $item['value'] }}' ? '{{ $on }}' : '{{ $off }}'"
                    x-bind:aria-pressed="{{ $model }} === '{{ $item['value'] }}'"
                    @click="{{ $model }} = '{{ $item['value'] }}'">
                @isset($item['icon'])<x-icon :name="$item['icon']" class="size-4" />@endisset{{ $item['label'] }}
            </button>
        @endif
    @endforeach
</div>
