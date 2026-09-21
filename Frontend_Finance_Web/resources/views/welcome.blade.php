<!DOCTYPE html>
<html lang="id">
<head>
    @section('title', 'Finapp - Perencanaan Keuangan Mudah untuk UMKM')
    @include('partials.head')
    <meta name="description" content="Finapp membantu pelaku UMKM mencatat transaksi, memantau kondisi keuangan, dan mendapat saran otomatis tanpa pusing spreadsheet.">
</head>
<body>
    @php
        $features = [
            ['icon' => 'bar-chart', 'tone' => 'accent', 'title' => 'Pencatatan keuangan yang pintar', 'text' => 'Catat pemasukan dan pengeluaran per kategori, lalu lihat kondisi usahamu secara langsung lewat ringkasan dan laporan yang mudah dibaca.'],
            ['icon' => 'sparkles', 'tone' => 'success', 'title' => 'Analisis dan saran otomatis', 'text' => 'Finapp membaca catatan transaksimu dan memberi saran sederhana yang bisa langsung dicoba untuk menjaga usaha tetap sehat.'],
            ['icon' => 'book-open', 'tone' => 'warning', 'title' => 'Pusat edukasi keuangan', 'text' => 'Kumpulan artikel dan panduan untuk menambah pemahaman keuangan, agar keputusan usahamu lebih percaya diri.'],
        ];
        $reasons = [
            'Tampilan mudah, dirancang untuk yang bukan ahli keuangan',
            'Pantau dan lihat laporan keuangan kapan saja',
            'Bisa dibuka dari mana saja lewat HP maupun komputer',
            'Fokus pada kebutuhan pemilik UMKM',
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
                <a href="{{ route('login') }}" class="hidden min-h-11 items-center rounded-full px-4 text-callout font-medium text-chrome-fg-muted transition-colors hover:bg-chrome-hover hover:text-chrome-fg sm:inline-flex">Masuk</a>
                <a href="{{ route('register') }}" class="inline-flex min-h-11 items-center rounded-full bg-white px-5 text-callout font-medium text-primary-800 transition-transform hover:scale-[1.03] active:scale-[0.98]">Daftar</a>
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
                <x-button :href="route('register')" size="lg" icon-right="arrow-right" class="w-full sm:w-auto">Coba gratis</x-button>
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
            <x-card padding="lg" class="sm:!p-12">
                <div class="grid items-center gap-10 lg:grid-cols-2">
                    <div>
                        <h2 class="text-title text-fg sm:text-largetitle">Kenapa memilih Finapp?</h2>
                        <p class="mt-4 text-body leading-relaxed text-fg-muted">
                            Finapp dirancang khusus untuk pemilik UMKM yang ingin memegang kendali atas keuangan usahanya. Alat keuangan yang kuat kami bungkus dalam tampilan yang ramah, supaya kamu bisa mengambil keputusan usaha dengan lebih baik.
                        </p>
                    </div>
                    <ul class="space-y-3">
                        @foreach ($reasons as $reason)
                            <li class="flex items-start gap-3 rounded-control bg-surface/60 p-4">
                                <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-success-soft text-success-fg"><x-icon name="check" class="size-3.5" /></span>
                                <span class="text-callout text-fg">{{ $reason }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </x-card>
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
            <div class="rounded-sheet bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 px-6 py-14 text-center text-white shadow-float sm:px-12">
                <h2 class="mx-auto max-w-xl text-title sm:text-largetitle">Siap merapikan keuangan usahamu?</h2>
                <p class="mx-auto mt-4 max-w-xl text-body text-white/85">Mulai gratis hari ini dan lihat kondisi usahamu dengan lebih jelas.</p>
                <a href="{{ route('register') }}" class="mt-8 inline-flex min-h-12 items-center justify-center gap-2 rounded-control bg-white px-7 text-body font-medium text-primary-800 transition-transform hover:scale-[1.02] active:scale-[0.98]">
                    Mulai sekarang <x-icon name="arrow-right" class="size-5" />
                </a>
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
                <a href="{{ route('login') }}" class="inline-flex min-h-11 items-center px-3 text-callout text-fg-muted transition-colors hover:text-fg">Masuk</a>
            </nav>
        </div>
        <p class="pb-8 text-center text-footnote text-fg-subtle">&copy; {{ date('Y') }} Finapp. Hak cipta dilindungi.</p>
    </footer>
</body>
</html>
