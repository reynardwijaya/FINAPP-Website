{{-- Bottom tab bar mobile (< lg): pil glass melayang, ramah jempol, hormati safe-area iPhone. --}}
@props(['items'])
<nav class="fixed inset-x-3 bottom-[max(0.75rem,env(safe-area-inset-bottom))] z-40 mx-auto max-w-lg rounded-sheet chrome p-1 lg:hidden" aria-label="Navigasi utama">
    <div class="flex">
        @foreach ($items as $item)
            <x-nav.item variant="tab" :href="$item['href']" :icon="$item['icon']" :label="$item['label']" :active="$item['active']" />
        @endforeach
    </div>
</nav>
