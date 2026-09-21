@extends('layouts.guest')

@section('title', 'Masuk - Finapp')

@section('content')
<main class="grid min-h-dvh place-items-center px-4 py-16">
    <div class="w-full max-w-md animate-enter">
        <div class="mb-8 text-center">
            <a href="{{ url('/') }}" aria-label="Finapp, ke halaman depan"><x-logo class="!text-largetitle" /></a>
            <p class="mt-2 text-callout text-fg-muted">Masuk untuk melihat kondisi keuangan usahamu.</p>
        </div>

        <x-card padding="lg">
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <x-input name="email" type="email" label="Email" autocomplete="email" placeholder="nama@email.com" required autofocus />
                <x-input name="password" type="password" label="Kata sandi" autocomplete="current-password" placeholder="Masukkan kata sandi" required />

                <div class="flex flex-wrap items-center justify-between gap-x-4">
                    <x-checkbox name="remember" label="Ingat saya" />
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="inline-flex min-h-11 items-center text-callout font-medium text-accent hover:underline">Lupa kata sandi?</a>
                    @endif
                </div>

                <x-button type="submit" size="lg" icon="log-out" class="w-full">Masuk</x-button>
            </form>
        </x-card>

        <p class="mt-6 text-center text-callout text-fg-muted">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-accent hover:underline">Daftar gratis</a>
        </p>
    </div>
</main>
@endsection
