@extends('layouts.app')

@section('title', 'Ubah Profil - Finapp')

@section('content')
@php $user = auth()->user(); @endphp
<div class="mx-auto max-w-2xl space-y-6">
    <x-page-header title="Ubah profil" subtitle="Perbarui foto, nama pengguna, dan email." />

    <x-card title="Foto profil">
        <form action="{{ route('profile.updateProfilePicture') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5 sm:flex-row sm:items-center">
            @csrf
            <x-avatar :user="$user" size="size-20" class="!text-title" />
            <div class="min-w-0 flex-1 space-y-2">
                <label for="profile_picture" class="block text-callout font-medium text-fg">Pilih foto baru</label>
                <input type="file" name="profile_picture" id="profile_picture" accept="image/png,image/jpeg,image/gif" required
                       class="block w-full text-callout text-fg-muted file:mr-4 file:min-h-11 file:cursor-pointer file:rounded-control file:border-0 file:bg-accent-soft file:px-4 file:font-medium file:text-accent hover:file:brightness-95">
                @error('profile_picture')
                    <p class="flex items-start gap-1.5 text-footnote text-danger-fg"><x-icon name="alert-circle" class="mt-px size-4" />{{ $message }}</p>
                @else
                    <p class="text-footnote text-fg-muted">JPG, PNG, atau GIF. Maksimal 2 MB.</p>
                @enderror
            </div>
            <x-button type="submit" variant="secondary" icon="camera">Unggah</x-button>
        </form>
    </x-card>

    <x-card title="Informasi akun">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            @method('PUT')
            <x-input name="username" label="Nama pengguna" :value="$user->username" autocomplete="username" required />
            <x-input name="email" type="email" label="Email" :value="$user->email" autocomplete="email" required />
            <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                <x-button :href="route('profile.show')" variant="secondary">Batal</x-button>
                <x-button type="submit" icon="check">Simpan perubahan</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
