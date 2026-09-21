{{--
    Drawer Masuk / Daftar: panel kaca membulat yang muncul dari sisi kanan landing page.
    Buka dari mana saja: $dispatch('open-auth', 'login' | 'register').
    Tanpa JavaScript, tautan tetap menuju /login dan /register (halaman landing dengan drawer terbuka).

    Form mengirim ke route yang sama (login / register). Field tersembunyi `_form` memberi tahu
    form mana yang harus dibuka lagi (beserta pesan error) bila validasi gagal.
--}}
@props(['mode' => null])
@php
    $none = new \Illuminate\Support\ViewErrorBag;
    $loginBag = $mode === 'login' ? $errors : $none;
    $registerBag = $mode === 'register' ? $errors : $none;
@endphp
<div x-data="{ open: @js($mode !== null), mode: @js($mode ?? 'login') }"
     x-on:open-auth.window="mode = $event.detail; open = true"
     x-on:keydown.escape.window="open = false"
     x-effect="if (open) $nextTick(() => setTimeout(() => document.getElementById(mode === 'login' ? 'login-email' : 'register-username')?.focus(), 350))"
     data-auth-open="{{ $mode }}">
    <template x-teleport="body">
        <div x-show="open" x-cloak class="fixed inset-0 z-[60]" role="dialog" aria-modal="true" aria-labelledby="auth-title">
            <div x-show="open" x-transition.opacity.duration.250ms class="fixed inset-0 bg-overlay backdrop-blur-sm" @click="open = false"></div>

            <aside x-show="open" x-trap.noscroll.inert="open"
                   x-transition:enter="transition duration-300 ease-ios" x-transition:enter-start="translate-x-8 opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                   x-transition:leave="transition duration-200 ease-ios" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-8 opacity-0"
                   class="glass-strong absolute inset-y-3 right-3 flex w-[calc(100%-1.5rem)] max-w-md flex-col overflow-hidden rounded-sheet shadow-float">

                <div class="flex items-start justify-between gap-4 px-6 pb-2 pt-6">
                    <div>
                        <h2 id="auth-title" class="text-title text-fg" x-text="mode === 'login' ? 'Masuk' : 'Daftar'"></h2>
                        <p class="mt-1 text-callout text-fg-muted" x-text="mode === 'login' ? 'Masuk untuk melihat kondisi keuangan usahamu.' : 'Buat akun untuk mulai mencatat keuangan usahamu.'"></p>
                    </div>
                    <button type="button" @click="open = false" aria-label="Tutup"
                            class="-mr-2 -mt-1 grid size-11 shrink-0 place-items-center rounded-full text-fg-muted transition-colors hover:bg-surface-muted hover:text-fg">
                        <x-icon name="x" />
                    </button>
                </div>

                <div class="px-6 pt-3">
                    <x-segmented model="mode" label="Masuk atau daftar" class="w-full" :items="[
                        ['label' => 'Masuk', 'value' => 'login'],
                        ['label' => 'Daftar', 'value' => 'register'],
                    ]" />
                </div>

                <div class="flex-1 overflow-y-auto px-6 pb-6 pt-5">
                    {{-- Masuk --}}
                    <form x-show="mode === 'login'" action="{{ route('login') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="_form" value="login">
                        <x-input id="login-email" name="email" type="email" label="Email" autocomplete="email" placeholder="nama@email.com" required
                                 :bag="$loginBag" :use-old="$mode === 'login'" />
                        <x-input id="login-password" name="password" type="password" label="Kata sandi" autocomplete="current-password" placeholder="Masukkan kata sandi" required
                                 :bag="$loginBag" />
                        <x-checkbox id="login-remember" name="remember" label="Ingat saya" />
                        <x-button type="submit" size="lg" icon="log-out" class="w-full">Masuk</x-button>
                        <p class="text-center text-callout text-fg-muted">Belum punya akun?
                            <button type="button" @click="mode = 'register'" class="font-medium text-accent hover:underline">Daftar gratis</button>
                        </p>
                    </form>

                    {{-- Daftar --}}
                    <form x-show="mode === 'register'" x-cloak action="{{ route('register') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="_form" value="register">
                        <x-input id="register-username" name="username" label="Nama pengguna" autocomplete="username" placeholder="Mis. Warung Bu Sari" required
                                 :bag="$registerBag" :use-old="$mode === 'register'" />
                        <x-input id="register-email" name="email" type="email" label="Email" autocomplete="email" placeholder="nama@email.com" required
                                 :bag="$registerBag" :use-old="$mode === 'register'" />
                        <x-input id="register-phone" name="phone_number" type="tel" label="Nomor telepon" autocomplete="tel" inputmode="tel" placeholder="08xxxxxxxxxx" required
                                 :bag="$registerBag" :use-old="$mode === 'register'" />
                        <x-input id="register-password" name="password" type="password" label="Kata sandi" autocomplete="new-password" placeholder="Minimal 8 karakter" required
                                 :bag="$registerBag" />
                        <x-input id="register-password-confirmation" name="password_confirmation" type="password" label="Ulangi kata sandi" autocomplete="new-password" placeholder="Ketik ulang kata sandi" required
                                 :bag="$registerBag" />
                        <x-button type="submit" size="lg" icon="check" class="w-full">Buat akun</x-button>
                        <p class="text-center text-callout text-fg-muted">Sudah punya akun?
                            <button type="button" @click="mode = 'login'" class="font-medium text-accent hover:underline">Masuk</button>
                        </p>
                    </form>
                </div>
            </aside>
        </div>
    </template>
</div>
