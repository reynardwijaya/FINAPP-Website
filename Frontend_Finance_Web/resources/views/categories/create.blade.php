@extends('layouts.app')

@section('title', 'Tambah Kategori - Finapp')

@section('content')
<div class="mx-auto max-w-2xl">
    <x-page-header title="Tambah kategori" subtitle="Kelompokkan transaksi supaya laporan lebih mudah dibaca." />
    <x-card padding="lg">
        @include('categories._form', ['action' => route('categories.store'), 'spoof' => null, 'category' => null, 'submitLabel' => 'Simpan kategori'])
    </x-card>
</div>
@endsection
