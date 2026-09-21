{{--
    Modal / bottom sheet. Bottom sheet di layar kecil, dialog di tengah di layar lebar.
    Buka:  $dispatch('open-modal', 'nama')   Tutup: $dispatch('close-modal', 'nama')
    Fokus dikunci di dalam dialog (x-trap), Esc menutup. Slot `footer` = tombol aksi.
--}}
@props(['name', 'title', 'description' => null, 'maxWidth' => 'sm:max-w-md'])
<div x-data="{ open: false }"
     x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
     x-on:close-modal.window="if ($event.detail === '{{ $name }}') open = false"
     x-on:keydown.escape.window="open = false">
    <template x-teleport="body">
        <div x-show="open" x-cloak class="fixed inset-0 z-[60] flex items-end justify-center sm:items-center sm:p-6"
             role="dialog" aria-modal="true" aria-labelledby="{{ $name }}-title">
            <div x-show="open" x-transition.opacity.duration.200ms class="fixed inset-0 bg-overlay backdrop-blur-sm" @click="open = false"></div>
            <div x-show="open" x-trap.noscroll.inert="open"
                 x-transition:enter="transition duration-300 ease-ios" x-transition:enter-start="translate-y-8 opacity-0 sm:translate-y-2 sm:scale-95"
                 x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                 x-transition:leave="transition duration-150 ease-ios" x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                 x-transition:leave-end="translate-y-8 opacity-0 sm:translate-y-2 sm:scale-95"
                 class="relative w-full {{ $maxWidth }} glass-strong rounded-t-sheet p-6 pb-[max(1.5rem,env(safe-area-inset-bottom))] shadow-float sm:rounded-sheet">
                <h2 id="{{ $name }}-title" class="text-headline text-fg">{{ $title }}</h2>
                @if ($description)<p class="mt-1.5 text-callout text-fg-muted">{{ $description }}</p>@endif
                @if (! $slot->isEmpty())<div class="mt-4">{{ $slot }}</div>@endif
                @isset($footer)<div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">{{ $footer }}</div>@endisset
            </div>
        </div>
    </template>
</div>
