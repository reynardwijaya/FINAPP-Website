{{-- Keadaan kosong yang ramah: ikon, judul, penjelasan singkat, dan satu aksi lanjutan (slot). --}}
@props(['icon' => 'inbox', 'title', 'description' => null])
<div {{ $attributes->class('flex flex-col items-center px-6 py-12 text-center') }}>
    <span class="grid size-14 place-items-center rounded-full bg-accent-soft text-accent"><x-icon :name="$icon" class="size-6" /></span>
    <h3 class="mt-4 text-headline text-fg">{{ $title }}</h3>
    @if ($description)<p class="mt-1 max-w-sm text-callout text-fg-muted">{{ $description }}</p>@endif
    @if (! $slot->isEmpty())<div class="mt-5">{{ $slot }}</div>@endif
</div>
