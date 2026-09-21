@extends('layouts.app')

@section('title', 'Transaksi - Finapp')

@section('content')
<x-page-header title="Transaksi" subtitle="Semua pemasukan dan pengeluaran usahamu.">
    <x-button :href="route('transactions.create')" icon="plus">Catat transaksi</x-button>
</x-page-header>

<x-card padding="none">
    @if ($transactions->isEmpty())
        <x-empty-state icon="wallet" title="Belum ada transaksi"
                       description="Catat pemasukan dan pengeluaran supaya kondisi keuanganmu terlihat jelas.">
            <x-button :href="route('transactions.create')" icon="plus">Catat transaksi pertama</x-button>
        </x-empty-state>
    @else
        {{-- Mobile: daftar kartu --}}
        <div class="divide-y divide-line px-5 md:hidden">
            @foreach ($transactions as $transaction)
                <x-transaction-item :transaction="$transaction">
                    <x-slot:actions>
                        <x-confirm-form :action="route('transactions.destroy', $transaction)" title="Hapus transaksi ini?"
                                        message="Transaksi akan dihapus permanen dan tidak bisa dikembalikan."
                                        trigger-label="Hapus transaksi" trigger-class="inline-flex min-h-11 items-center gap-1.5 rounded-control px-2 text-footnote font-medium text-danger-fg hover:bg-danger-soft">
                            <x-icon name="trash" class="size-4" />Hapus
                        </x-confirm-form>
                    </x-slot:actions>
                </x-transaction-item>
            @endforeach
        </div>

        {{-- Desktop: tabel --}}
        <x-table class="hidden md:block">
            <thead>
                <tr>
                    <th>Tanggal</th><th>Jenis</th><th>Kategori</th><th>Deskripsi</th>
                    <th class="text-right">Jumlah</th><th class="text-right"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td class="whitespace-nowrap text-fg-muted">{{ $transaction->transaction_date?->locale('id')->translatedFormat('d M Y') ?? '-' }}</td>
                        <td><x-transaction-type :type="$transaction->type" /></td>
                        <td>
                            @if ($transaction->category)
                                <span class="inline-flex items-center gap-2">
                                    <span class="size-2.5 rounded-full" style="background-color: {{ $transaction->category->color }}"></span>{{ $transaction->category->name }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="max-w-64 truncate text-fg-muted">{{ $transaction->description ?? '-' }}</td>
                        <td class="text-right"><x-amount :value="$transaction->amount" :type="$transaction->type" /></td>
                        <td class="text-right">
                            <x-confirm-form :action="route('transactions.destroy', $transaction)" title="Hapus transaksi ini?"
                                            message="Transaksi akan dihapus permanen dan tidak bisa dikembalikan."
                                            trigger-label="Hapus transaksi" trigger-class="grid size-11 place-items-center rounded-full text-fg-subtle transition-colors hover:bg-danger-soft hover:text-danger-fg">
                                <x-icon name="trash" />
                            </x-confirm-form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-table>

        @if ($transactions->hasPages())
            <div class="border-t border-line px-5 py-4 sm:px-6">{{ $transactions->links() }}</div>
        @endif
    @endif
</x-card>
@endsection
