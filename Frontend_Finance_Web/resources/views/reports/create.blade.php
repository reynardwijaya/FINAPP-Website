@extends('layouts.app')

@section('title', 'Buat Laporan - Finapp')

@section('content')
<div class="mx-auto max-w-2xl">
    <x-page-header title="Tambah data laporan" subtitle="Isi data pemasukan atau pengeluaran yang akan masuk ke laporan." />

    <x-card padding="lg">
        <form action="{{ route('reports.store') }}" method="POST" class="space-y-5">
            @csrf

            <x-select name="type" label="Jenis transaksi" required>
                <option value="">Pilih jenis</option>
                <option value="income" @selected(old('type', 'income') == 'income')>Pemasukan (uang masuk)</option>
                <option value="expense" @selected(old('type') == 'expense')>Pengeluaran (uang keluar)</option>
            </x-select>

            <x-select name="category_id" id="category" label="Kategori" required data-old-category="{{ old('category_id') }}">
                <option value="">Pilih kategori</option>
            </x-select>
            <p id="category-empty" class="-mt-3 hidden text-footnote text-fg-muted">
                Belum ada kategori untuk jenis ini.
                <a href="{{ route('categories.create') }}" class="font-medium text-accent underline underline-offset-2">Buat kategori</a>
            </p>

            <x-input name="amount" label="Jumlah" prefix="Rp" type="number" step="0.01" min="0" inputmode="decimal"
                     placeholder="0" required />

            <x-input name="transaction_date" label="Tanggal" type="date" :value="date('Y-m-d')" required />

            <x-textarea name="description" label="Catatan" optional rows="3"
                        placeholder="Mis. Penjualan harian, beli bahan baku" />

            <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                <x-button :href="route('reports.index')" variant="secondary">Batal</x-button>
                <x-button type="submit" icon="check">Simpan data</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const typeSelect = document.getElementById('type');
    const categorySelect = document.getElementById('category');
    const emptyHint = document.getElementById('category-empty');
    let oldCategoryId = categorySelect.dataset.oldCategory;

    let latestRequest = 0;

    async function loadCategories() {
        const selectedType = typeSelect.value;
        const request = ++latestRequest;
        categorySelect.innerHTML = '<option value="">Pilih kategori</option>';
        emptyHint.classList.add('hidden');
        if (!selectedType) return;

        try {
            const response = await fetch(`/categories/type/${selectedType}`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            const categories = await response.json();
            if (request !== latestRequest) return; // jenis sudah diganti; abaikan respons lama

            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                if (oldCategoryId && String(category.id) === oldCategoryId) option.selected = true;
                categorySelect.appendChild(option);
            });
            emptyHint.classList.toggle('hidden', categories.length > 0);
        } catch (error) {
            window.Finapp.toast('Kategori gagal dimuat. Coba muat ulang halaman.', 'error');
        }
    }

    loadCategories();
    typeSelect.addEventListener('change', () => {
        oldCategoryId = '';
        loadCategories();
    });
    // Segarkan daftar kategori saat kembali dari halaman Kategori
    window.addEventListener('focus', () => {
        oldCategoryId = categorySelect.value || oldCategoryId;
        loadCategories();
    });
});
</script>
@endpush
