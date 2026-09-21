@extends('layouts.app')

@section('title', 'Ubah Kategori - Finapp')

@section('content')
<div class="mx-auto max-w-2xl">
    <x-page-header title="Ubah kategori" :subtitle="$category->name" />
    <x-card padding="lg">
        @include('categories._form', ['action' => route('categories.update', $category), 'spoof' => 'PUT', 'category' => $category, 'submitLabel' => 'Simpan perubahan'])
    </x-card>
</div>
@endsection
