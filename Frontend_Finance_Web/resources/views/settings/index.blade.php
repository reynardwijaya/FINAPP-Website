@extends('layouts.app')

@section('title', 'Pengaturan - Finapp')

@section('content')
@php
    $prefs = $user->preferences ?? null;
    $sec = $user->security_settings ?? null;
    $initialTab = $errors->hasAny(['current_password', 'password', 'password_confirmation', 'two_factor_enabled', 'login_notifications', 'session_timeout'])
        ? 'security'
        : ($errors->hasAny(['theme', 'default_view', 'transaction_reminders', 'monthly_report', 'notifications', 'email_notifications']) ? 'preferences' : 'profile');
    $tabs = [
        ['label' => 'Profil', 'value' => 'profile', 'icon' => 'user'],
        ['label' => 'Tampilan', 'value' => 'preferences', 'icon' => 'sun'],
        ['label' => 'Notifikasi', 'value' => 'notifications', 'icon' => 'bell'],
        ['label' => 'Keamanan', 'value' => 'security', 'icon' => 'lock'],
        ['label' => 'Kategori', 'value' => 'categories', 'icon' => 'tag'],
    ];
    $now = now();
@endphp

<x-page-header title="Pengaturan" subtitle="Atur akun, tampilan, dan keamanan sesuai kebutuhanmu." />

<div x-data="{ tab: @js($initialTab) }"
     x-init="const h = location.hash.slice(1); if (['profile','preferences','notifications','security','categories'].includes(h) && ! @js($errors->any())) tab = h"
     x-effect="history.replaceState(null, '', '#' + tab)"
     class="mx-auto max-w-3xl space-y-6">

    <div class="-mx-4 overflow-x-auto px-4 sm:mx-0 sm:px-0">
        <x-segmented model="tab" label="Bagian pengaturan" :items="$tabs" class="min-w-max" />
    </div>

    {{-- Profil --}}
    <div x-show="tab === 'profile'" x-cloak class="animate-enter">
        <x-card title="Profil" subtitle="Informasi akun dan preferensi regional">
            <form action="{{ route('settings.updateProfile') }}" method="POST" class="grid gap-5 sm:grid-cols-2">
                @csrf
                @method('PUT')
                <x-input name="username" label="Nama pengguna" :value="$user->username" autocomplete="username" required />
                <x-input name="email" type="email" label="Email" :value="$user->email" autocomplete="email" required />

                <x-select name="currency" label="Mata uang">
                    @foreach (['USD' => 'USD ($)', 'EUR' => 'EUR (€)', 'GBP' => 'GBP (£)', 'IDR' => 'IDR (Rp)'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('currency', $user->currency) == $value)>{{ $label }}</option>
                    @endforeach
                </x-select>
                <x-select name="language" label="Bahasa">
                    <option value="en" @selected(old('language', $user->language) == 'en')>English</option>
                    <option value="id" @selected(old('language', $user->language) == 'id')>Bahasa Indonesia</option>
                </x-select>
                <x-select name="timezone" label="Zona waktu">
                    @foreach (['UTC' => 'UTC', 'Asia/Jakarta' => 'Asia/Jakarta (WIB)', 'Asia/Makassar' => 'Asia/Makassar (WITA)', 'Asia/Jayapura' => 'Asia/Jayapura (WIT)'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('timezone', $user->timezone) == $value)>{{ $label }}</option>
                    @endforeach
                </x-select>
                <x-select name="date_format" label="Format tanggal">
                    @foreach (['Y-m-d', 'd/m/Y', 'm/d/Y'] as $format)
                        <option value="{{ $format }}" @selected(old('date_format', $user->date_format) == $format)>{{ $now->format($format) }}</option>
                    @endforeach
                </x-select>

                <div class="flex justify-end sm:col-span-2"><x-button type="submit" icon="check">Simpan profil</x-button></div>
            </form>
        </x-card>
    </div>

    {{-- Tampilan & notifikasi: satu form (route dan field sama seperti sebelumnya) --}}
    <form action="{{ route('settings.updatePreferences') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div x-show="tab === 'preferences'" x-cloak class="animate-enter">
            <x-card title="Tampilan" subtitle="Tema dan halaman awal">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <span class="block text-callout font-medium text-fg">Tema</span>
                        <x-theme-toggle variant="segmented" class="w-full sm:w-auto" />
                        <p class="text-footnote text-fg-muted">Tema berlaku langsung di perangkat ini.</p>
                        {{-- nilai yang dikirim ke server mengikuti tema yang sedang aktif --}}
                        <input type="hidden" name="theme" x-data :value="$store.theme.mode" value="{{ old('theme', $prefs->theme ?? 'system') }}">
                    </div>

                    <x-select name="default_view" label="Halaman awal setelah masuk">
                        @foreach (['dashboard' => 'Beranda', 'transactions' => 'Transaksi', 'reports' => 'Laporan'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('default_view', $prefs->default_view ?? 'dashboard') == $value)>{{ $label }}</option>
                        @endforeach
                    </x-select>

                    <div class="divide-y divide-line">
                        <input type="hidden" name="transaction_reminders" value="0">
                        <x-checkbox name="transaction_reminders" label="Ingatkan saya mencatat transaksi" hint="Pengingat harian agar pencatatan tidak terlewat." :checked="(bool) ($prefs->transaction_reminders ?? false)" />
                        <input type="hidden" name="monthly_report" value="0">
                        <x-checkbox name="monthly_report" label="Kirim laporan bulanan" hint="Ringkasan keuangan setiap awal bulan." :checked="(bool) ($prefs->monthly_report ?? false)" />
                    </div>
                </div>
            </x-card>
        </div>

        <div x-show="tab === 'notifications'" x-cloak class="animate-enter">
            <x-card title="Notifikasi" subtitle="Pilih kabar yang ingin kamu terima">
                <div class="divide-y divide-line">
                    <input type="hidden" name="notifications" value="0">
                    <x-checkbox name="notifications" label="Notifikasi di aplikasi" hint="Pemberitahuan penting saat kamu memakai Finapp." :checked="(bool) ($prefs->notifications ?? true)" />
                    <input type="hidden" name="email_notifications" value="0">
                    <x-checkbox name="email_notifications" label="Notifikasi lewat email" hint="Kabar dan ringkasan dikirim ke emailmu." :checked="(bool) ($prefs->email_notifications ?? true)" />
                </div>
            </x-card>
        </div>

        <div x-show="tab === 'preferences' || tab === 'notifications'" x-cloak class="flex justify-end">
            <x-button type="submit" icon="check">Simpan pengaturan</x-button>
        </div>
    </form>

    {{-- Keamanan --}}
    <div x-show="tab === 'security'" x-cloak class="animate-enter space-y-6">
        <x-card title="Ganti kata sandi" subtitle="Gunakan kata sandi yang panjang dan sulit ditebak">
            <form action="{{ route('settings.updatePassword') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <x-input name="current_password" type="password" label="Kata sandi saat ini" autocomplete="current-password" required />
                <x-input name="password" type="password" label="Kata sandi baru" autocomplete="new-password" required />
                <x-input name="password_confirmation" type="password" label="Ulangi kata sandi baru" autocomplete="new-password" required />
                <div class="flex justify-end"><x-button type="submit" icon="lock">Ganti kata sandi</x-button></div>
            </form>
        </x-card>

        <x-card title="Keamanan akun" subtitle="Perlindungan tambahan untuk akunmu">
            <form action="{{ route('settings.updateSecurity') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div class="divide-y divide-line">
                    <input type="hidden" name="two_factor_enabled" value="0">
                    <x-checkbox name="two_factor_enabled" label="Verifikasi dua langkah" hint="Minta kode tambahan saat masuk." :checked="(bool) ($sec->two_factor_enabled ?? false)" />
                    <input type="hidden" name="login_notifications" value="0">
                    <x-checkbox name="login_notifications" label="Beri tahu saat ada login baru" hint="Kami kabari kalau akunmu dibuka dari perangkat lain." :checked="(bool) ($sec->login_notifications ?? false)" />
                </div>
                <x-input name="session_timeout" type="number" min="5" max="120" label="Batas waktu sesi (menit)" :value="$sec->session_timeout ?? 30"
                         hint="Kamu otomatis keluar setelah tidak aktif selama waktu ini (5 sampai 120 menit)." />
                <div class="flex justify-end"><x-button type="submit" icon="check">Simpan keamanan</x-button></div>
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
