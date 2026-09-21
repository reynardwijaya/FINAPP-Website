@extends('layouts.guest')

@section('title', 'Daftar - Finapp')

@section('content')
<main class="grid min-h-dvh place-items-center px-4 py-16">
    <div class="w-full max-w-md animate-enter">
        <div class="mb-8 text-center">
            <a href="{{ url('/') }}" aria-label="Finapp, ke halaman depan"><x-logo class="!text-largetitle" /></a>
            <p class="mt-2 text-callout text-fg-muted">Buat akun untuk mulai mencatat keuangan usahamu.</p>
        </div>

        <x-card padding="lg">
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <x-input name="username" label="Nama pengguna" autocomplete="username" placeholder="Mis. Warung Bu Sari" required autofocus />
                <x-input name="email" type="email" label="Email" autocomplete="email" placeholder="nama@email.com" required />
                <x-input name="phone_number" type="tel" label="Nomor telepon" autocomplete="tel" inputmode="tel" placeholder="08xxxxxxxxxx" required />
                <x-input name="password" type="password" label="Kata sandi" autocomplete="new-password" placeholder="Buat kata sandi" required />
                <x-input name="password_confirmation" type="password" label="Ulangi kata sandi" autocomplete="new-password" placeholder="Ketik ulang kata sandi" required />

                <x-button type="submit" size="lg" icon="check" class="w-full">Buat akun</x-button>
            </form>
        </x-card>

        <p class="mt-6 text-center text-callout text-fg-muted">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-accent hover:underline">Masuk</a>
        </p>
    </div>
</main>
@endsection
