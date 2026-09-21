{{--
    Pemilih tema: Terang / Gelap / Sistem. Memakai modul tema tunggal (Alpine.store('theme') -> resources/js/theme.js).
    variant="menu" (default, tombol ikon + dropdown) atau "segmented" (tiga pilihan sejajar, untuk Pengaturan).
--}}
@props(['variant' => 'menu', 'align' => 'right', 'chrome' => false])
@php
    $options = [
        ['value' => 'light', 'label' => 'Terang', 'icon' => 'sun'],
        ['value' => 'dark', 'label' => 'Gelap', 'icon' => 'moon'],
        ['value' => 'system', 'label' => 'Sistem', 'icon' => 'monitor'],
    ];
@endphp
@if ($variant === 'segmented')
    <div role="group" aria-label="Tema tampilan" {{ $attributes->class('inline-flex max-w-full gap-1 rounded-control bg-surface-muted/70 p-1 backdrop-blur-md') }}>
        @foreach ($options as $o)
            <button type="button" x-data @click="$store.theme.set('{{ $o['value'] }}')"
                    x-bind:aria-pressed="$store.theme.mode === '{{ $o['value'] }}'"
                    x-bind:class="$store.theme.mode === '{{ $o['value'] }}' ? 'bg-surface text-fg shadow-card' : 'text-fg-muted hover:text-fg'"
                    class="inline-flex min-h-10 flex-1 items-center justify-center gap-2 rounded-[0.55rem] px-3.5 text-callout font-medium transition-[background-color,color,box-shadow]">
                <x-icon :name="$o['icon']" class="size-4" />{{ $o['label'] }}
            </button>
        @endforeach
    </div>
@else
    <x-dropdown :align="$align" width="w-44">
        <x-slot:trigger>
            <button type="button" aria-label="Ganti tema" aria-haspopup="menu" x-data
                    class="grid size-11 place-items-center rounded-full transition-colors {{ $chrome ? 'text-chrome-fg-muted hover:bg-chrome-hover hover:text-chrome-fg' : 'text-fg-muted hover:bg-surface-muted hover:text-fg' }}">
                <x-icon name="sun" x-show="$store.theme.resolved !== 'dark'" />
                <x-icon name="moon" x-show="$store.theme.resolved === 'dark'" x-cloak />
            </button>
        </x-slot:trigger>
        @foreach ($options as $o)
            <button type="button" role="menuitemradio" x-data @click="$store.theme.set('{{ $o['value'] }}')"
                    x-bind:aria-checked="$store.theme.mode === '{{ $o['value'] }}'"
                    class="flex w-full min-h-11 items-center gap-3 rounded-[0.7rem] px-3 text-left text-callout text-fg transition-colors hover:bg-surface-muted">
                <x-icon :name="$o['icon']" class="size-[1.125rem] text-fg-muted" />
                <span class="flex-1">{{ $o['label'] }}</span>
                <x-icon name="check" class="size-4 text-accent" x-show="$store.theme.mode === '{{ $o['value'] }}'" x-cloak />
            </button>
        @endforeach
    </x-dropdown>
@endif
