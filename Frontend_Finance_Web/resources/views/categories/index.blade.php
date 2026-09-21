@extends('layouts.app')

@section('title', 'Kategori - Finapp')

@section('content')
@php
    $groups = [
        ['title' => 'Kategori pemasukan', 'subtitle' => 'Sumber uang masuk', 'icon' => 'arrow-up-right', 'tone' => 'success', 'items' => $incomeCategories, 'empty' => 'Belum ada kategori pemasukan.'],
        ['title' => 'Kategori pengeluaran', 'subtitle' => 'Ke mana uang keluar', 'icon' => 'arrow-down-left', 'tone' => 'danger', 'items' => $expenseCategories, 'empty' => 'Belum ada kategori pengeluaran.'],
    ];
    $chip = ['success' => 'bg-success-soft text-success-fg', 'danger' => 'bg-danger-soft text-danger-fg'];
@endphp

<x-page-header title="Kategori" subtitle="Kelompokkan transaksi supaya laporan lebih mudah dibaca.">
    <x-button :href="route('categories.create')" icon="plus">Tambah kategori</x-button>
</x-page-header>

<div class="grid gap-6 lg:grid-cols-2">
    @foreach ($groups as $group)
        <x-card padding="none">
            <div class="flex items-center gap-3 border-b border-line px-5 py-4 sm:px-6">
                <span class="grid size-9 place-items-center rounded-full {{ $chip[$group['tone']] }}"><x-icon :name="$group['icon']" class="size-[1.125rem]" /></span>
                <div>
                    <h2 class="text-headline text-fg">{{ $group['title'] }}</h2>
                    <p class="text-footnote text-fg-muted">{{ $group['subtitle'] }}</p>
                </div>
            </div>

            @if ($group['items']->isEmpty())
                <x-empty-state icon="tag" :title="$group['empty']" description="Tambahkan kategori agar transaksi bisa dikelompokkan." />
            @else
                <ul class="divide-y divide-line px-5 sm:px-6">
                    @foreach ($group['items'] as $category)
                        <li class="flex items-center gap-3 py-3">
                            {{-- warna kategori berasal dari data pengguna (inline style yang sah) --}}
                            <span class="grid size-10 shrink-0 place-items-center rounded-full text-white" style="background-color: {{ $category->color }}">
                                <x-category-icon :icon="$category->icon" class="size-5" />
                            </span>
                            <span class="min-w-0 flex-1 truncate text-callout font-medium text-fg">{{ $category->name }}</span>
                            @if ($category->is_default)
                                <x-badge tone="info">Bawaan</x-badge>
                            @else
                                <a href="{{ route('categories.edit', $category) }}" aria-label="Ubah kategori {{ $category->name }}"
                                   class="grid size-11 place-items-center rounded-full text-fg-subtle transition-colors hover:bg-surface-muted hover:text-fg"><x-icon name="pencil" /></a>
                                <x-confirm-form :action="route('categories.destroy', $category)" title="Hapus kategori “{{ $category->name }}”?"
                                                message="Kategori yang masih dipakai transaksi tidak bisa dihapus."
                                                trigger-label="Hapus kategori {{ $category->name }}"
                                                trigger-class="grid size-11 place-items-center rounded-full text-fg-subtle transition-colors hover:bg-danger-soft hover:text-danger-fg">
                                    <x-icon name="trash" />
                                </x-confirm-form>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-card>
    @endforeach
</div>
@endsection
