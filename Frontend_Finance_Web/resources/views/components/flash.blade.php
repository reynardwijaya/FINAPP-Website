{{--
    Toast. Menampilkan flash session (success / error / status) dan pesan dari JS:
    Finapp.toast('Tersimpan', 'success')  |  type: success | error | info
    Letakkan satu kali di layout.
--}}
@php
    $initial = collect([
        ['type' => 'success', 'message' => session('success')],
        ['type' => 'error', 'message' => session('error')],
        ['type' => 'info', 'message' => session('status')],
    ])->filter(fn ($t) => $t['message'])->values()->map(fn ($t, $i) => $t + ['id' => $i + 1]);
@endphp
<div x-data="{
        items: @js($initial),
        n: 100,
        add(message, type = 'success') {
            const id = ++this.n;
            this.items.push({ id, message, type });
            setTimeout(() => this.remove(id), 5000);
        },
        remove(id) { this.items = this.items.filter(i => i.id !== id); },
     }"
     x-init="items.forEach(i => setTimeout(() => remove(i.id), 5000))"
     x-on:toast.window="add($event.detail.message, $event.detail.type)"
     class="pointer-events-none fixed inset-x-0 top-[4.5rem] z-[70] flex flex-col items-center gap-2 px-4">
    <template x-for="item in items" :key="item.id">
        <div x-transition:enter="transition duration-300 ease-ios" x-transition:enter-start="-translate-y-2 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
             :role="item.type === 'error' ? 'alert' : 'status'"
             class="pointer-events-auto flex w-full max-w-md items-start gap-3 glass-strong rounded-card p-4">
            <span class="mt-0.5 shrink-0" :class="item.type === 'error' ? 'text-danger-fg' : (item.type === 'info' ? 'text-info-fg' : 'text-success-fg')">
                <x-icon name="check-circle" x-show="item.type === 'success'" />
                <x-icon name="alert-circle" x-show="item.type === 'error'" />
                <x-icon name="info" x-show="item.type === 'info'" />
            </span>
            <p class="min-w-0 flex-1 text-callout text-fg" x-text="item.message"></p>
            <button type="button" class="-m-2 grid size-11 shrink-0 place-items-center rounded-full text-fg-subtle hover:text-fg" aria-label="Tutup pesan" @click="remove(item.id)">
                <x-icon name="x" class="size-4" />
            </button>
        </div>
    </template>
</div>
