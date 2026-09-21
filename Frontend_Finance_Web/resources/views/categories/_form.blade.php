{{--
    Form kategori bersama (create & edit).
    Variabel: $action (URL), $spoof (mis. 'PUT' atau null), $category (Category|null), $submitLabel.
    Kontrak data tidak berubah: name, type, color (#RRGGBB), icon (string class Font Awesome, mis. "fas fa-tag").
    Picker ikon menyimpan nilai class yang sama; ikon lama di luar daftar tetap dipertahankan.
--}}
@php
    $category = $category ?? null;
    $iconOptions = [
        'fas fa-tag' => 'Umum', 'fas fa-shopping-cart' => 'Belanja', 'fas fa-utensils' => 'Makanan',
        'fas fa-car' => 'Transportasi', 'fas fa-home' => 'Rumah', 'fas fa-bolt' => 'Listrik',
        'fas fa-heart' => 'Kesehatan', 'fas fa-gift' => 'Hadiah', 'fas fa-briefcase' => 'Usaha',
        'fas fa-book' => 'Pendidikan', 'fas fa-coffee' => 'Kopi', 'fas fa-credit-card' => 'Tagihan',
        'fas fa-wallet' => 'Dompet', 'fas fa-money-bill-wave' => 'Uang', 'fas fa-chart-line' => 'Investasi',
        'fas fa-mobile-alt' => 'Pulsa',
    ];
    $currentIcon = old('icon', $category->icon ?? 'fas fa-tag');
    if ($currentIcon && ! isset($iconOptions[$currentIcon])) {
        $iconOptions = [$currentIcon => 'Ikon saat ini'] + $iconOptions;
    }
    $color = old('color', $category->color ?? '#7546E0');
@endphp

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if (! empty($spoof))@method($spoof)@endif

    <x-input name="name" label="Nama kategori" :value="$category->name ?? null" placeholder="Mis. Bahan baku" required />

    @if ($category)
        {{-- Jenis tidak bisa diubah setelah dibuat --}}
        <div class="space-y-1.5">
            <span class="block text-callout font-medium text-fg">Jenis</span>
            <div class="flex min-h-11 items-center rounded-control border border-line bg-surface-muted/70 px-3.5 text-body text-fg-muted">
                {{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
            </div>
            <input type="hidden" name="type" value="{{ $category->type }}">
            <p class="text-footnote text-fg-muted">Jenis kategori tidak bisa diubah.</p>
        </div>
    @else
        <x-select name="type" label="Jenis" required>
            <option value="income" @selected(old('type') == 'income')>Pemasukan (uang masuk)</option>
            <option value="expense" @selected(old('type', 'expense') == 'expense')>Pengeluaran (uang keluar)</option>
        </x-select>
    @endif

    {{-- Warna: color picker + kode hex (disinkronkan) --}}
    <x-field label="Warna" name="color" for="color" hint="Dipakai di grafik dan daftar transaksi.">
        <div class="flex items-center gap-3">
            <input type="color" name="color" id="color" value="{{ $color }}" required aria-label="Pilih warna"
                   class="size-11 shrink-0 cursor-pointer rounded-control border border-line-strong bg-transparent p-1">
            <input type="text" id="colorText" value="{{ $color }}" pattern="^#[0-9A-Fa-f]{6}$" placeholder="#RRGGBB" aria-label="Kode warna heksadesimal"
                   class="block min-h-11 w-36 rounded-control border border-line-strong bg-surface/70 px-3.5 text-body uppercase text-fg backdrop-blur-sm focus:border-ring focus:bg-surface focus:outline-none focus:ring-[3px] focus:ring-ring/25">
        </div>
    </x-field>

    {{-- Ikon --}}
    <fieldset>
        <legend class="mb-2 block text-callout font-medium text-fg">Ikon <span class="font-normal text-fg-subtle">(opsional)</span></legend>
        <div class="grid grid-cols-4 gap-2 sm:grid-cols-6" role="radiogroup">
            @foreach ($iconOptions as $value => $label)
                <label class="cursor-pointer" title="{{ $label }}">
                    <input type="radio" name="icon" value="{{ $value }}" class="peer sr-only" @checked($currentIcon === $value)>
                    <span class="flex min-h-14 flex-col items-center justify-center gap-1 rounded-control border border-line bg-surface/60 px-1 py-2 text-fg-muted transition-colors hover:bg-surface peer-checked:border-ring peer-checked:bg-accent-soft peer-checked:text-accent peer-focus-visible:ring-[3px] peer-focus-visible:ring-ring/40">
                        <x-category-icon :icon="$value" class="size-5" />
                        <span class="text-caption">{{ $label }}</span>
                    </span>
                </label>
            @endforeach
        </div>
        @error('icon')<p class="mt-2 flex items-start gap-1.5 text-footnote text-danger-fg"><x-icon name="alert-circle" class="mt-px size-4" />{{ $message }}</p>@enderror
    </fieldset>

    <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
        <x-button :href="route('categories.index')" variant="secondary">Batal</x-button>
        <x-button type="submit" icon="check">{{ $submitLabel }}</x-button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const picker = document.getElementById('color');
    const text = document.getElementById('colorText');
    picker.addEventListener('input', () => { text.value = picker.value; });
    text.addEventListener('input', () => { if (/^#[0-9A-Fa-f]{6}$/.test(text.value)) picker.value = text.value; });
});
</script>
