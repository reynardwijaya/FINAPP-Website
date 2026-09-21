# Design System Finapp

Gaya: tenang, minimalis, terasa seperti produk Apple (clarity, deference, depth). Konten adalah bintangnya; UI hanya membingkai. Mode terang dan gelap dirancang setara.

Semua token ada di [`resources/css/app.css`](../resources/css/app.css). Komponen ada di `resources/views/components/`.

## Cara kerja tema

| Hal | Implementasi |
|---|---|
| Penanda mode gelap | class `dark` di `<html>` |
| Penyimpanan | `localStorage.theme` = `light` / `dark`. Tanpa key = **Sistem** (ikut OS) |
| Tanpa flash | script inline kecil di `resources/views/partials/head.blade.php` menerapkan class sebelum render pertama |
| Modul JS | `resources/js/theme.js` (satu-satunya). API: `Finapp.theme.set('light' \| 'dark' \| 'system')`, `.mode`, `.resolved` |
| Mode Sistem | mendengarkan `prefers-color-scheme` secara langsung |
| Event | `finapp:theme` di `document` dengan `detail: { mode, resolved }`. Chart.js dan komponen lain cukup mendengarkan ini |
| Native control | `color-scheme` diatur lewat CSS (`:root` terang, `.dark` gelap), jadi scrollbar/form bawaan ikut tema |
| Variant Tailwind | `@custom-variant dark (&:where(.dark, .dark *))` |

Preferensi tema **hanya** di browser (belum sinkron antar perangkat). Kolom `preferences.theme` di database tetap disimpan oleh form Pengaturan tetapi tidak dibaca untuk menerapkan tampilan.

## Token warna semantik

Komponen memakai token semantik. Nilainya berganti otomatis di mode gelap, jadi **hampir tidak perlu `dark:`**.

| Utility | Fungsi | Terang | Gelap |
|---|---|---|---|
| `bg-canvas` | latar halaman (lavender tipis) | #F5F3FD | #0E0C16 |
| `bg-surface` | kartu, panel | #FFFFFF | #171425 |
| `bg-surface-elevated` | dropdown, modal, toast | #FFFFFF | #1F1B31 |
| `bg-surface-muted` | area sekunder, hover, skeleton | #F4F3F9 | #221E36 |
| `text-fg` | teks utama | #1D1B2E | #F3F1FA |
| `text-fg-muted` | teks sekunder | #5B5870 | #B4B0C8 |
| `text-fg-subtle` | teks tersier, placeholder | #625F78 | #918DAE |
| `border-line` / `border-line-strong` | pemisah / batas input | #ECEAF3 / #DAD7E6 | #2A2640 / #3A3557 |
| `bg-primary` `hover:bg-primary-hover` `text-on-primary` | tombol aksi utama | violet-600 / 700 / putih | sama |
| `text-accent`, `bg-accent-soft` | teks/ikon/link ungu, state aktif | violet-600, violet-100 | violet-300, ungu 16% |
| `ring-ring` | focus ring | violet-500 | violet-400 |
| `success` `danger` `warning` `info` | isi/ikon/bar | lihat `app.css` | lebih terang |
| `*-fg` | teks di atas `*-soft` (AA) | lebih gelap | sama dengan isi |
| `*-soft` | latar lencana/banner | tint pastel | warna transparan 14% |

Skala `primary-50 … primary-950` (violet) tersedia untuk kasus khusus (mis. gradien hero).

### Penyesuaian palet dari spesifikasi awal

Nilai diverifikasi dengan rasio kontras WCAG. Yang disetel:

- `fg-subtle` terang `#8E8BA3` → `#625F78` (3,3:1 → ≥ 4,97:1 bahkan di atas glass berwarna terburuk). Gelap `#8480A0` → `#918DAE` (4,3:1 di `surface-muted` → 5,1:1).
- Teks semantik terang dipisah dari warna isi: `success-fg #0F7A54`, `danger-fg #C62F35`, `warning-fg #8F5B00`, `info-fg #2A66C9`. Warna isi asli (#1F9D6B, #E5484D, dst.) hanya 2,1 sampai 3,4:1 di atas latar pastelnya. Di mode gelap warna asli sudah lolos, jadi `-fg` sama dengan isi.
- Canvas terang `#FAFAFC` → `#F5F3FD` (lavender tipis) supaya mode terang tidak terasa putih polos.
- Tombol bahaya: putih di atas `danger-fg` (terang); teks gelap di atas `danger` (gelap).
- Batas input (`line-strong`) sengaja halus (1,4:1) sesuai gaya Apple; keadaan fokus (ring 3px) dan error (border merah + ikon + teks) tidak bergantung pada batas itu.

### Aturan menambah warna baru

1. Jangan tulis hex di view, `style=""`, atau JS. Pakai token.
2. Butuh warna baru? Tambahkan sebagai `--color-nama` di `@theme` (nilai terang) **dan** timpa di blok `.dark` di `app.css`. Utility (`bg-nama`, `text-nama`) otomatis tersedia.
3. Beri pasangan `-soft` (latar) dan `-fg` (teks) bila dipakai untuk status. Cek kontras teks ≥ 4,5:1 di kedua mode.
4. `dark:` hanya untuk pengecualian (mis. tombol bahaya), bukan untuk warna umum.
5. Pemasukan/pengeluaran **tidak boleh** dibedakan hanya dengan warna: sertakan `+`/`−`, ikon panah, atau label.
6. Satu-satunya inline style yang sah: warna kategori dari database (data pengguna).

## Tipografi

Font: `-apple-system, "SF Pro Display/Text"` lebih dulu, lalu **Inter** (self-hosted, subset latin, ±48 kB) di perangkat non-Apple.

| Utility | Ukuran | Pemakaian |
|---|---|---|
| `text-largetitle` | 34px | judul halaman (desktop), angka utama |
| `text-title` | 24px | judul halaman (mobile), angka kartu |
| `text-headline` | 17px | judul kartu |
| `text-body` | 16px | isi, input |
| `text-callout` | 15px | label, tombol, navigasi |
| `text-footnote` | 13px | bantuan, header tabel |
| `text-caption` | 12px | lencana, tab bar |

Bobot hanya 400/500/600. Angka uang memakai class `num` (`tabular-nums`), format Rupiah `Rp 1.250.000`.

## Bentuk, kedalaman, gerak

- Radius: `rounded-card` 18px, `rounded-control` 12px (input/tombol), `rounded-sheet` 24px, chip `rounded-full`.
- Terang: `shadow-card` / `shadow-raised` / `shadow-float` yang halus dan berlapis. Gelap: shadow dihilangkan; kedalaman dari tingkat surface + border.
- **Glass di seluruh sistem** (keputusan desain): kartu, panel, menu, modal, dan toast memakai `glass` / `glass-strong` (latar translusen + blur + hairline + highlight tipis). `glass-strong` dipakai untuk lapisan yang menimpa konten (menu, modal, toast) agar teks tetap AA.
- **Chrome** (`chrome`): sidebar, top bar, dan tab bar berupa panel ungu tua translusen di mode terang (mode gelap: glass gelap). Teks di dalamnya memakai token `text-chrome-fg`, `text-chrome-fg-muted`, `bg-chrome-hover`, `bg-chrome-active`, `border-chrome-line`; menu dropdown di dalam chrome tetap memakai glass terang biasa.
- Agar blur terlihat, `body::before` menggambar cahaya ambient (violet, pink, biru, mint di mode terang; ungu di mode gelap) lewat token `--ambient-1..4`. Matikan dengan mengubah token itu menjadi `transparent`.
- Fallback: tanpa dukungan `backdrop-filter` atau bila pengguna memilih `prefers-reduced-transparency`, glass/chrome menjadi permukaan solid dan cahaya ambient dimatikan.
- Semua elemen berbentuk kotak dibulatkan: sidebar `rounded-sheet` (melayang, `inset-y-3 left-3`), top bar `rounded-card` (mobile) / pil `rounded-full` (desktop, pojok kanan atas), tab bar `rounded-sheet`.
- Gerak 150 sampai 300ms, easing `ease-ios`. `prefers-reduced-motion` mematikan animasi secara global.
- Target sentuh ≥ 44px (`min-h-11`).

## Komponen

| Komponen | Catatan |
|---|---|
| `<x-icon name="…">` | SVG inline gaya Lucide, `aria-hidden` bawaan (beri `label` bila bermakna). Daftar ikon di `resources/views/icons.php`; tambah ikon dengan menambah satu baris. |
| `<x-category-icon :icon="$category->icon">` | memetakan class Font Awesome tersimpan di `categories.icon` ke ikon SVG; tidak dikenal → ikon tag |
| `<x-button>` | `variant`: primary/secondary/soft/ghost/danger; `size`: sm/md/lg/icon; `href` → tautan. Tombol `type="submit"` otomatis disabled + spinner setelah form valid dikirim. Tombol ikon wajib `aria-label`. |
| `<x-input>` `<x-select>` `<x-textarea>` | label, `hint`, `optional`, `prefix`, error otomatis dari `$errors`, `old()` otomatis |
| `<x-checkbox>` | label + hint, area sentuh penuh |
| `<x-card>` | `title`, `subtitle`, slot `action`, `padding="none"` untuk tabel, `interactive` |
| `<x-stat>` | kartu angka; `hero` = kartu utama bergradien ungu (maks. satu per layar) |
| `<x-badge>` | `tone`: neutral/accent/success/danger/warning/info |
| `<x-table>` | tabel lega; sembunyikan di mobile dan tampilkan daftar kartu |
| `<x-segmented>` | segmented control: mode tautan (`href`) atau panel Alpine (`model`) |
| `<x-modal>` | bottom sheet di mobile, dialog di desktop; fokus terkunci, Esc menutup. Buka: `$dispatch('open-modal', 'nama')` |
| `<x-confirm-form>` | konfirmasi hapus; form yang dikirim sama persis (action + `_method` + CSRF) |
| `<x-dropdown>` `<x-dropdown-item>` | menu akun dan sejenisnya |
| `<x-flash>` | toast dari flash session; dari JS: `Finapp.toast('Tersimpan', 'success')` |
| `<x-theme-toggle>` | `variant="menu"` (ikon + menu) atau `"segmented"` |
| `<x-alert>` | banner inline info/success/warning/danger |
| `<x-empty-state>` `<x-skeleton>` | keadaan kosong dan loading (varian gelap otomatis) |
| `<x-avatar>` `<x-logo>` `<x-page-header>` | identitas dan judul halaman. `x-logo` = wordmark teks "Finapp" (tanpa gambar logo); `avatar`/`logo`/`theme-toggle` punya prop `chrome` untuk dipakai di atas sidebar/top bar berwarna |
| `<x-amount>` | nominal Rupiah `Rp 1.250.000`; dengan `type` menambah tanda +/− dan teks pembaca layar |
| `<x-transaction-type>` `<x-transaction-item>` | lencana jenis transaksi (warna + ikon + teks) dan baris kartu transaksi untuk mobile |
| `<x-nav.sidebar>` `<x-nav.tabbar>` `<x-nav.topbar>` `<x-nav.item>` | navigasi: sidebar (≥ lg), bottom tab bar (< lg), top bar |

## Layout

- `layouts/app.blade.php`: shell aplikasi (sidebar melayang di desktop, tab bar melayang di mobile, top bar: pil kanan atas di desktop / selebar layar di mobile). Daftar menu ada di satu tempat (`$navItems`, `$navSecondary`) dan dipakai sidebar, tab bar, dan menu akun.
- `layouts/guest.blade.php`: halaman auth. `welcome.blade.php` memakai `partials/head` yang sama.
- Pagination memakai `resources/views/vendor/pagination/tailwind.blade.php` (Bahasa Indonesia, gaya sama).
- Judul halaman: `@section('title', '…')`. Skrip halaman: `@push('scripts')` (dirender di akhir `<body>`).

## Grafik (Chart.js)

`resources/js/charts.js` menyediakan satu helper; halaman tidak mengatur warna/font sendiri.

```js
Finapp.charts.create('idCanvas', (t) => ({
    type: 'line',
    data: { labels, datasets: [{ label: 'Pemasukan', data, borderColor: t.income }] },
    options: { scales: Finapp.charts.axes(t) },
}));
```

- `t` = token tema aktif (`income`, `expense`, `series[0..5]`, `grid`, `tick`, …) dibaca dari CSS variable `--chart-*`.
- Saat event `finapp:theme` terpancar, semua grafik dibangun ulang otomatis (tanpa animasi). Tidak perlu reload.
- Helper lain: `rupiah(n)`, `rupiahCompact(n)`, `withAlpha(hex, a)`.
- Maksimal 6 warna per grafik. Warna kategori dari database tetap dipakai apa adanya.
