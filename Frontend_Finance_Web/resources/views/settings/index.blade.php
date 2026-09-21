@extends('layouts.app')

@section('title', 'Pengaturan - Finapp')

@section('content')
@php
    $initialTab = $errors->hasAny(['current_password', 'password', 'password_confirmation']) ? 'security' : 'profile';
    $tabs = [
        ['label' => 'Profil', 'value' => 'profile', 'icon' => 'user'],
        ['label' => 'Tampilan', 'value' => 'appearance', 'icon' => 'sun'],
        ['label' => 'Keamanan', 'value' => 'security', 'icon' => 'lock'],
        ['label' => 'Kategori', 'value' => 'categories', 'icon' => 'tag'],
    ];
@endphp

<x-page-header title="Pengaturan" subtitle="Atur profil, tampilan, dan keamanan akunmu." />

<div x-data="{ tab: @js($initialTab) }"
     x-init="const h = location.hash.slice(1); if (['profile','appearance','security','categories'].includes(h) && ! @js($errors->any())) tab = h"
     x-effect="history.replaceState(null, '', '#' + tab)"
     class="mx-auto max-w-3xl space-y-6">

    <div class="-mx-4 overflow-x-auto px-4 sm:mx-0 sm:px-0">
        <x-segmented model="tab" label="Bagian pengaturan" :items="$tabs" class="min-w-max" />
    </div>

    {{-- Profil --}}
    <div x-show="tab === 'profile'" x-cloak class="animate-enter">
        <x-card title="Profil" subtitle="Data akun yang kamu pakai untuk masuk">
            <div class="flex items-center gap-4">
                <x-avatar :user="$user" size="size-16" class="!text-headline" />
                <div class="min-w-0">
                    <p class="truncate text-headline text-fg">{{ $user->username }}</p>
                    <p class="truncate text-callout text-fg-muted">{{ $user->email }}</p>
                </div>
            </div>
            <div class="mt-6 flex flex-wrap gap-3">
                <x-button :href="route('profile.edit')" icon="pencil">Ubah profil</x-button>
                <x-button :href="route('profile.show')" variant="secondary">Lihat profil</x-button>
            </div>
        </x-card>
    </div>

    {{-- Tampilan: tema tersimpan di perangkat ini (modul tema tunggal) --}}
    <div x-show="tab === 'appearance'" x-cloak class="animate-enter">
        <x-card title="Tampilan" subtitle="Pilih tema yang nyaman di matamu">
            <x-theme-toggle variant="segmented" class="w-full sm:w-auto" />
            <p class="mt-3 text-footnote text-fg-muted">Terang atau Gelap berlaku langsung. Sistem mengikuti pengaturan perangkatmu. Pilihan ini tersimpan di perangkat ini.</p>
        </x-card>
    </div>

    {{-- Keamanan --}}
    <div x-show="tab === 'security'" x-cloak class="animate-enter">
        <x-card title="Ganti kata sandi" subtitle="Gunakan kata sandi yang panjang dan sulit ditebak">
            <form action="{{ route('settings.updatePassword') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <x-input name="current_password" type="password" label="Kata sandi saat ini" autocomplete="current-password" required />
                <x-input name="password" type="password" label="Kata sandi baru" autocomplete="new-password" hint="Minimal 8 karakter." required />
                <x-input name="password_confirmation" type="password" label="Ulangi kata sandi baru" autocomplete="new-password" required />
                <div class="flex justify-end"><x-button type="submit" icon="lock">Ganti kata sandi</x-button></div>
            </form>
        </x-card>
    </div>

    {{-- Kategori --}}
    <div x-show="tab === 'categories'" x-cloak class="animate-enter">
        <x-card title="Kategori transaksi" subtitle="Kelompokkan pemasukan dan pengeluaran">
            <p class="text-callout text-fg-muted">Tambah, ubah, atau hapus kategori supaya laporan dan grafik sesuai dengan cara kamu mengelola usaha.</p>
            <div class="mt-5"><x-button :href="route('categories.index')" icon="tag" variant="secondary">Kelola kategori</x-button></div>
        </x-card>
    </div>
</div>
@endsection
