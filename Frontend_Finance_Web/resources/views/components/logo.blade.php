{{-- Identitas Finapp: wordmark teks saja (tanpa gambar logo). `chrome` = di atas sidebar/top bar berwarna. --}}
@props(['chrome' => false])
<span {{ $attributes->class(['text-title font-semibold tracking-tight', $chrome ? 'text-chrome-fg' : 'text-fg']) }}>Finapp</span>
