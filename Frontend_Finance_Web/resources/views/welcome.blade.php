<!DOCTYPE html>
<html lang="id">
<head>
    @section('title', 'Finapp - Perencanaan Keuangan Mudah untuk UMKM')
    @include('partials.head')
    <meta name="description" content="Finapp membantu pelaku UMKM mencatat transaksi, memantau kondisi keuangan, dan mendapat saran otomatis tanpa pusing spreadsheet.">
</head>
<body x-data>
    @php
        // Error kredensial dikirim balik tanpa input lama (tanpa _form): anggap dari form Masuk.
        $authMode = $authMode ?? old('_form') ?? ($errors->any() ? 'login' : null);
        $loggedIn = auth()->check();
        $features = [
            ['icon' => 'bar-chart', 'tone' => 'accent', 'title' => 'Pencatatan keuangan yang pintar', 'text' => 'Catat pemasukan dan pengeluaran per kategori, lalu lihat kondisi usahamu secara langsung lewat ringkasan dan laporan yang mudah dibaca.'],
            ['icon' => 'sparkles', 'tone' => 'success', 'title' => 'Analisis dan saran otomatis', 'text' => 'Finapp membaca catatan transaksimu dan memberi saran sederhana yang bisa langsung dicoba untuk menjaga usaha tetap sehat.'],
            ['icon' => 'book-open', 'tone' => 'warning', 'title' => 'Pusat edukasi keuangan', 'text' => 'Kumpulan artikel dan panduan untuk menambah pemahaman keuangan, agar keputusan usahamu lebih percaya diri.'],
        ];
        $reasons = [
            ['icon' => 'layout-dashboard', 'chip' => 'bg-accent-soft text-accent', 'title' => 'Mudah dipakai', 'text' => 'Dirancang untuk yang bukan ahli keuangan: bahasa sederhana dan langkah singkat.'],
            ['icon' => 'bar-chart', 'chip' => 'bg-success-soft text-success-fg', 'title' => 'Pantau kapan saja', 'text' => 'Ringkasan dan laporan keuangan selalu siap dilihat, tanpa rekap manual.'],
            ['icon' => 'smartphone', 'chip' => 'bg-info-soft text-info-fg', 'title' => 'Dari mana saja', 'text' => 'Nyaman dibuka lewat HP maupun komputer, di rumah atau di lapak.'],
            ['icon' => 'briefcase', 'chip' => 'bg-warning-soft text-warning-fg', 'title' => 'Fokus untuk UMKM', 'text' => 'Fitur dan istilahnya disesuaikan dengan kebutuhan pemilik usaha kecil.'],
        ];
        $testimonials = [
            ['name' => 'Budi Santoso', 'role' => 'Pemilik usaha cuci helm', 'text' => 'Finapp mengubah cara saya mengatur keuangan usaha. Saran otomatisnya membantu saya mengambil keputusan yang lebih baik.'],
            ['name' => 'Siti Rahayu', 'role' => 'Pemilik usaha kecil', 'text' => 'Fitur pencatatannya gampang sekali dipakai. Sekarang saya bisa fokus mengembangkan usaha tanpa pusing soal keuangan.'],
            ['name' => 'Ahmad Rizki', 'role' => 'Wirausahawan', 'text' => 'Analisisnya membantu saya melihat peluang baru dan merapikan operasional usaha. Sangat direkomendasikan!'],
        ];
    @endphp

    {{-- Navigasi --}}
    <header class="fixed inset-x-0 top-0 z-50 px-4 pt-3 sm:px-6">
        <div class="chrome mx-auto flex h-14 max-w-6xl items-center justify-between gap-3 rounded-full pl-5 pr-2">
            <a href="{{ url('/') }}" aria-label="Finapp, ke atas"><x-logo chrome /></a>
            <nav class="hidden items-center gap-1 md:flex" aria-label="Bagian halaman">
                @foreach ([['#fitur', 'Fitur'], ['#tentang', 'Tentang'], ['#testimoni', 'Testimoni']] as [$href, $label])
                    <a href="{{ $href }}" class="inline-flex min-h-11 items-center rounded-full px-4 text-callout font-medium text-chrome-fg-muted transition-colors hover:bg-chrome-hover hover:text-chrome-fg">{{ $label }}</a>
                @endforeach
            </nav>
            <div class="flex items-center gap-1">
                <x-theme-toggle chrome />
                @if ($loggedIn)
                    <a href="{{ route('dashboard') }}" class="inline-flex min-h-11 items-center rounded-full bg-white px-5 text-callout font-medium text-primary-800 transition-transform hover:scale-[1.03] active:scale-[0.98]">Buka Beranda</a>
                @else
                    <a href="{{ route('login') }}" @click.prevent="$dispatch('open-auth', 'login')" class="hidden min-h-11 items-center rounded-full px-4 text-callout font-medium text-chrome-fg-muted transition-colors hover:bg-chrome-hover hover:text-chrome-fg sm:inline-flex">Masuk</a>
                    <a href="{{ route('register') }}" @click.prevent="$dispatch('open-auth', 'register')" class="inline-flex min-h-11 items-center rounded-full bg-white px-5 text-callout font-medium text-primary-800 transition-transform hover:scale-[1.03] active:scale-[0.98]">Daftar</a>
                @endif
            </div>
        </div>
    </header>

    <main>
        {{-- Hero --}}
        <section class="mx-auto max-w-6xl px-4 pb-16 pt-32 text-center sm:px-6 sm:pt-40">
            <h1 class="animate-enter mx-auto max-w-3xl text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-fg sm:text-6xl">
                Perencanaan keuangan yang mudah untuk <span class="bg-gradient-to-r from-primary-600 via-primary-500 to-pink-500 bg-clip-text text-transparent">UMKM</span>
            </h1>
            <p class="animate-enter mx-auto mt-6 max-w-2xl text-body leading-relaxed text-fg-muted sm:text-xl">
                Catat transaksi, pantau kondisi keuangan, dan dapatkan saran otomatis. Semua dalam beberapa klik, tanpa pusing dengan spreadsheet.
            </p>
            <div class="animate-enter mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                @if ($loggedIn)
                    <x-button :href="route('dashboard')" size="lg" icon-right="arrow-right" class="w-full sm:w-auto">Buka Beranda</x-button>
                @else
                    <x-button :href="route('register')" @click.prevent="$dispatch('open-auth', 'register')" size="lg" icon-right="arrow-right" class="w-full sm:w-auto">Coba gratis</x-button>
                @endif
                <x-button href="#fitur" variant="secondary" size="lg" class="w-full sm:w-auto">Pelajari lebih lanjut</x-button>
            </div>

            <div class="glass mx-auto mt-14 max-w-4xl overflow-hidden rounded-sheet p-2 sm:p-3">
                <img src="{{ asset('images/dashboard-preview-light.webp') }}" alt="Tampilan halaman Beranda Finapp" width="1280" height="800" class="w-full rounded-[1.1rem] dark:hidden">
                <img src="{{ asset('images/dashboard-preview-dark.webp') }}" alt="Tampilan halaman Beranda Finapp dalam mode gelap" width="1280" height="800" class="hidden w-full rounded-[1.1rem] dark:block">
            </div>
        </section>

        {{-- Fitur --}}
        <section id="fitur" class="mx-auto max-w-6xl scroll-mt-24 px-4 py-16 sm:px-6">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-title text-fg sm:text-largetitle">Fitur untuk membantu usahamu</h2>
                <p class="mt-3 text-body text-fg-muted">Semua yang kamu perlukan untuk mengelola keuangan dengan tenang.</p>
            </div>
            <div class="mt-10 grid gap-5 md:grid-cols-3">
                @foreach ($features as $f)
                    @php $chip = ['accent' => 'bg-accent-soft text-accent', 'success' => 'bg-success-soft text-success-fg', 'warning' => 'bg-warning-soft text-warning-fg'][$f['tone']]; @endphp
                    <x-card interactive padding="lg">
                        <span class="grid size-12 place-items-center rounded-2xl {{ $chip }}"><x-icon :name="$f['icon']" class="size-6" /></span>
                        <h3 class="mt-5 text-headline text-fg">{{ $f['title'] }}</h3>
                        <p class="mt-2 text-callout leading-relaxed text-fg-muted">{{ $f['text'] }}</p>
                    </x-card>
                @endforeach
            </div>
        </section>

        {{-- Tentang --}}
        <section id="tentang" class="mx-auto max-w-6xl scroll-mt-24 px-4 py-16 sm:px-6">
            <div class="grid gap-5 lg:grid-cols-5">
                <div class="relative overflow-hidden rounded-sheet bg-gradient-to-br from-primary-600 to-primary-800 p-8 text-white shadow-raised sm:p-10 lg:col-span-2">
                    <div aria-hidden="true" class="pointer-events-none absolute -right-16 -top-16 size-56 rounded-full bg-pink-400/30 blur-3xl"></div>
                    <div aria-hidden="true" class="pointer-events-none absolute -bottom-20 -left-10 size-56 rounded-full bg-sky-400/25 blur-3xl"></div>
                    <div class="relative">
                        <h2 class="text-title sm:text-largetitle">Kenapa memilih Finapp?</h2>
                        <p class="mt-4 text-body leading-relaxed text-white/85">
                            Finapp dirancang khusus untuk pemilik UMKM yang ingin memegang kendali atas keuangan usahanya. Alat keuangan yang kuat kami bungkus dalam tampilan yang ramah, supaya kamu bisa mengambil keputusan usaha dengan lebih baik.
                        </p>
                    </div>
                </div>
                <div class="grid gap-5 sm:grid-cols-2 lg:col-span-3">
                    @foreach ($reasons as $r)
                        <x-card interactive padding="lg" class="animate-enter">
                            <span class="grid size-12 place-items-center rounded-2xl {{ $r['chip'] }}"><x-icon :name="$r['icon']" class="size-6" /></span>
                            <h3 class="mt-5 text-headline text-fg">{{ $r['title'] }}</h3>
                            <p class="mt-2 text-callout leading-relaxed text-fg-muted">{{ $r['text'] }}</p>
                        </x-card>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Testimoni (contoh) --}}
        <section id="testimoni" class="mx-auto max-w-6xl scroll-mt-24 px-4 py-16 sm:px-6">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-title text-fg sm:text-largetitle">Kata pengguna</h2>
                <p class="mt-3 text-body text-fg-muted">Cerita dari pemilik usaha yang terbantu Finapp.</p>
            </div>
            <div class="mt-10 grid gap-5 md:grid-cols-3">
                @foreach ($testimonials as $t)
                    <x-card as="figure" padding="lg" class="flex flex-col">
                        <blockquote class="flex-1 text-callout leading-relaxed text-fg">“{{ $t['text'] }}”</blockquote>
                        <figcaption class="mt-6 flex items-center gap-3">
                            <span aria-hidden="true" class="grid size-11 shrink-0 place-items-center rounded-full bg-accent-soft text-callout font-semibold text-accent">{{ mb_substr($t['name'], 0, 1) }}</span>
                            <span>
                                <span class="block text-callout font-medium text-fg">{{ $t['name'] }}</span>
                                <span class="block text-footnote text-fg-muted">{{ $t['role'] }}</span>
                            </span>
                        </figcaption>
                    </x-card>
                @endforeach
            </div>
        </section>

        {{-- Ajakan --}}
        <section class="mx-auto max-w-6xl px-4 pb-24 pt-8 sm:px-6">
            <div class="relative overflow-hidden rounded-sheet bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 px-6 py-14 text-white shadow-float sm:px-12 sm:py-16">
                <div aria-hidden="true" class="pointer-events-none absolute -left-24 -top-24 size-80 rounded-full bg-pink-400/30 blur-3xl"></div>
                <div aria-hidden="true" class="pointer-events-none absolute -bottom-28 right-0 size-96 rounded-full bg-sky-400/25 blur-3xl"></div>
                <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgb(255_255_255/0.12)_1px,transparent_0)] [background-size:22px_22px] [mask-image:linear-gradient(to_bottom,black,transparent_85%)]"></div>

                <div class="relative grid items-center gap-10 lg:grid-cols-5">
                    <div class="lg:col-span-3">
                        <h2 class="text-title sm:text-largetitle">Siap merapikan keuangan usahamu?</h2>
                        <p class="mt-4 max-w-xl text-body leading-relaxed text-white/85">Mulai gratis hari ini dan lihat kondisi usahamu dengan lebih jelas.</p>
                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            @if ($loggedIn)
                                <a href="{{ route('dashboard') }}" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-control bg-white px-7 text-body font-medium text-primary-800 shadow-raised transition-transform hover:scale-[1.02] active:scale-[0.98]">
                                    Buka Beranda <x-icon name="arrow-right" class="size-5" />
                                </a>
                            @else
                                <a href="{{ route('register') }}" @click.prevent="$dispatch('open-auth', 'register')" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-control bg-white px-7 text-body font-medium text-primary-800 shadow-raised transition-transform hover:scale-[1.02] active:scale-[0.98]">
                                    Mulai sekarang <x-icon name="arrow-right" class="size-5" />
                                </a>
                                <a href="{{ route('login') }}" @click.prevent="$dispatch('open-auth', 'login')" class="inline-flex min-h-12 items-center justify-center rounded-control border border-white/30 bg-white/10 px-7 text-body font-medium text-white backdrop-blur-md transition-colors hover:bg-white/20">
                                    Sudah punya akun
                                </a>
                            @endif
                        </div>
                        <ul class="mt-7 flex flex-wrap gap-x-6 gap-y-2 text-callout text-white/90">
                            @foreach (['Gratis dicoba', 'Tanpa spreadsheet', 'Bisa dari HP'] as $point)
                                <li class="flex items-center gap-2"><x-icon name="check-circle" class="size-[1.125rem] text-emerald-300" />{{ $point }}</li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Ilustrasi: kartu kaca melayang --}}
                    <div aria-hidden="true" class="relative hidden h-56 lg:col-span-2 lg:block">
                        <div class="animate-float absolute right-0 top-0 flex items-center gap-3 rounded-card border border-white/25 bg-white/15 px-4 py-3 backdrop-blur-xl">
                            <span class="grid size-10 place-items-center rounded-full bg-white/20"><x-icon name="arrow-left-right" class="size-5" /></span>
                            <span class="text-callout font-medium">Catat transaksi</span>
                        </div>
                        <div class="animate-float absolute left-0 top-[4.5rem] flex items-center gap-3 rounded-card border border-white/25 bg-white/15 px-4 py-3 backdrop-blur-xl [animation-delay:-2s]">
                            <span class="grid size-10 place-items-center rounded-full bg-white/20"><x-icon name="bar-chart" class="size-5" /></span>
                            <span class="text-callout font-medium">Laporan otomatis</span>
                        </div>
                        <div class="animate-float absolute bottom-0 right-6 flex items-center gap-3 rounded-card border border-white/25 bg-white/15 px-4 py-3 backdrop-blur-xl [animation-delay:-4s]">
                            <span class="grid size-10 place-items-center rounded-full bg-white/20"><x-icon name="lightbulb" class="size-5" /></span>
                            <span class="text-callout font-medium">Saran untukmu</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-line">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-6 px-4 py-10 sm:flex-row sm:px-6">
            <div class="text-center sm:text-left">
                <x-logo />
                <p class="mt-1 text-footnote text-fg-muted">Perencanaan keuangan mudah untuk pemilik UMKM.</p>
            </div>
            <nav class="flex flex-wrap items-center justify-center gap-x-2" aria-label="Tautan footer">
                @foreach ([['#fitur', 'Fitur'], ['#tentang', 'Tentang'], ['#testimoni', 'Testimoni']] as [$href, $label])
                    <a href="{{ $href }}" class="inline-flex min-h-11 items-center px-3 text-callout text-fg-muted transition-colors hover:text-fg">{{ $label }}</a>
                @endforeach
                @unless ($loggedIn)
                    <a href="{{ route('login') }}" @click.prevent="$dispatch('open-auth', 'login')" class="inline-flex min-h-11 items-center px-3 text-callout text-fg-muted transition-colors hover:text-fg">Masuk</a>
                @endunless
            </nav>
        </div>
        <p class="pb-8 text-center text-footnote text-fg-subtle">&copy; {{ date('Y') }} Finapp. Hak cipta dilindungi.</p>
    </footer>

    @unless ($loggedIn)
        <x-auth-drawer :mode="$authMode" />
    @endunless
    <x-flash />
</body>
</html>
