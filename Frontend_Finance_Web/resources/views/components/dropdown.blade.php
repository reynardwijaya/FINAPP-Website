{{--
    Dropdown menu. Slot `trigger` = tombol pemicu (beri aria-label bila hanya ikon).
    Isi menu = <x-dropdown-item>. Esc / klik di luar menutup.
--}}
@props(['align' => 'right', 'width' => 'w-60'])
<div x-data="{ open: false }" x-on:keydown.escape.window="open = false" x-on:click.outside="open = false" class="relative">
    <div x-on:click="open = ! open" x-bind:aria-expanded="open">{{ $trigger }}</div>
    <div x-show="open" x-cloak
         x-transition:enter="transition duration-200 ease-ios" x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100"
         x-transition:leave="transition duration-100 ease-ios" x-transition:leave-start="scale-100 opacity-100" x-transition:leave-end="scale-95 opacity-0"
         x-on:click="open = false"
         role="menu"
         class="absolute z-50 mt-2 {{ $width }} {{ $align === 'left' ? 'left-0 origin-top-left' : 'right-0 origin-top-right' }} glass-strong rounded-card p-1.5">
        {{ $slot }}
    </div>
</div>
