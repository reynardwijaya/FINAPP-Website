@extends('layouts.app')

@section('title', 'Profil - Finapp')

@section('content')
@php
    $income = $user->transactions()->where('type', 'income')->sum('amount');
    $expense = $user->transactions()->where('type', 'expense')->sum('amount');
    $net = $income - $expense;
    $count = $user->transactions()->count();
    $last = $user->transactions()->latest()->first();
    $rp = fn ($n) => ($n < 0 ? '−' : '').'Rp '.number_format(abs($n), 0, ',', '.');
    $fmt = fn ($d) => $d?->locale('id')->translatedFormat('d F Y, H:i');
@endphp

<x-page-header title="Profil" subtitle="Data akun dan ringkasan aktivitasmu.">
    <x-button :href="route('profile.edit')" icon="pencil">Ubah profil</x-button>
</x-page-header>

<div class="space-y-6">
    {{-- Identitas --}}
    <x-card padding="lg">
        <div class="flex flex-col items-center gap-5 text-center sm:flex-row sm:text-left">
            <form action="{{ route('profile.updateProfilePicture') }}" method="POST" enctype="multipart/form-data" class="relative shrink-0">
                @csrf
                <x-avatar :user="$user" size="size-24" class="!text-title" />
                <label for="profile_picture_upload" class="absolute -bottom-1 -right-1 grid size-11 cursor-pointer place-items-center rounded-full bg-primary text-on-primary shadow-raised transition-colors hover:bg-primary-hover focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-ring">
                    <x-icon name="camera" class="size-5" />
                    <span class="sr-only">Ganti foto profil</span>
                    <input type="file" name="profile_picture" id="profile_picture_upload" accept="image/png,image/jpeg,image/gif" class="sr-only" onchange="this.form.submit()">
                </label>
            </form>
            <div class="min-w-0">
                <h2 class="truncate text-title text-fg">{{ $user->username }}</h2>
                <p class="mt-0.5 truncate text-callout text-fg-muted">{{ $user->email }}</p>
                <p class="mt-2 text-footnote text-fg-subtle">Anggota sejak {{ $user->created_at->locale('id')->translatedFormat('d F Y') }}</p>
            </div>
        </div>
        @error('profile_picture')
            <x-alert type="danger" class="mt-5">{{ $message }}</x-alert>
        @enderror
    </x-card>

    {{-- Ringkasan seumur akun --}}
    <section aria-label="Ringkasan seluruh transaksi" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="Jumlah transaksi" icon="arrow-left-right" tone="accent" :value="number_format($count, 0, ',', '.')" />
        <x-stat label="Total pemasukan" icon="arrow-up-right" tone="success" :value="$rp($income)" />
        <x-stat label="Total pengeluaran" icon="arrow-down-left" tone="danger" :value="$rp($expense)" />
        <x-stat label="Selisih" icon="wallet" tone="warning" :value="$rp($net)" hint="Pemasukan dikurangi pengeluaran" />
    </section>

    <div class="grid gap-6 lg:grid-cols-2">
        <x-card title="Informasi akun">
            <dl class="divide-y divide-line">
                @foreach ([
                    ['Nama pengguna', $user->username],
                    ['Email', $user->email],
                    ['Nomor telepon', $user->phone_number ?: '-'],
                    ['Terakhir diperbarui', $fmt($user->updated_at) ?? '-'],
                ] as [$label, $value])
                    <div class="flex flex-col gap-0.5 py-3 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between sm:gap-6">
                        <dt class="text-callout text-fg-muted">{{ $label }}</dt>
                        <dd class="break-all text-callout font-medium text-fg sm:text-right">{{ $value }}</dd>
                    </div>
                @endforeach
                <div class="flex items-center justify-between gap-6 py-3 last:pb-0">
                    <dt class="text-callout text-fg-muted">Status akun</dt>
                    <dd><x-badge tone="success" icon="check">Aktif</x-badge></dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Aktivitas terakhir">
            @if ($last)
                <p class="text-callout text-fg-muted">Transaksi terakhir dicatat pada</p>
                <p class="mt-1 text-headline text-fg">{{ $fmt($last->created_at) }}</p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <x-button :href="route('transactions.index')" variant="secondary" size="sm">Lihat transaksi</x-button>
                    <x-button :href="route('settings.index')" variant="ghost" size="sm" icon="settings">Pengaturan</x-button>
                </div>
            @else
                <x-empty-state icon="wallet" title="Belum ada aktivitas" description="Catat transaksi pertamamu untuk mulai.">
                    <x-button :href="route('transactions.create')" icon="plus" size="sm">Catat transaksi</x-button>
                </x-empty-state>
            @endif
        </x-card>
    </div>
</div>
@endsection
