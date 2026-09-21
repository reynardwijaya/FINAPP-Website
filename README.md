# Finapp

Finapp adalah aplikasi web pencatatan dan analisis keuangan untuk pelaku UMKM. Alih-alih pusing dengan spreadsheet, pemilik usaha kecil bisa mencatat transaksi, memantau kondisi keuangan, dan mendapat saran sederhana hanya dalam beberapa klik. Antarmukanya berbahasa Indonesia, mobile-first, dengan tema terang, gelap, dan ikut sistem.

## Fitur

- **Beranda**: saldo bulan ini, pemasukan, pengeluaran, tren 6 bulan, dan pembagian per kategori
- **Transaksi**: catat pemasukan dan pengeluaran per kategori, hapus dengan konfirmasi
- **Kategori**: buat, ubah, dan hapus kategori dengan warna dan ikon
- **Laporan**: saring transaksi berdasarkan tanggal dan jenis
- **Analisis**: ringkasan dan saran otomatis (bulanan atau tahunan) berbasis aturan sederhana dari data transaksi
- **Artikel edukasi**: cari, filter topik, dan baca artikel keuangan untuk UMKM
- **Profil dan pengaturan**: foto, nama, email, kata sandi, dan tema tampilan
- **Login dan daftar** lewat drawer di landing page

## Tech Stack

| Layer | Teknologi |
|---|---|
| Web framework | Laravel 12 (PHP 8.2+) |
| Frontend | Blade, Alpine.js 3, Tailwind CSS 4 |
| Build tool | Vite 6 |
| Grafik | Chart.js 4 |
| Database | SQLite (default) atau MySQL |
| Test | PHPUnit 11 |
| Service AI (terpisah, opsional) | Go 1.23 dan Google Gemini API |

Service Go di `Backend_Go` berdiri sendiri dan belum dipanggil oleh aplikasi web. Analisis di aplikasi web dihasilkan oleh aturan PHP, bukan AI.

## Struktur Repo

```text
FINAPP-Website/
├── Frontend_Finance_Web/   # Aplikasi web Laravel
└── Backend_Go/             # Service AI (Go), opsional
```

## Instalasi

Prasyarat: PHP 8.2+ (ekstensi `pdo_sqlite`, `mbstring`, `openssl`, `fileinfo`), Composer 2, Node.js 18+ dengan npm. Go 1.23 dan MySQL hanya dibutuhkan untuk `Backend_Go`.

```bash
git clone https://github.com/reynardwijaya/FINAPP-Website.git
cd FINAPP-Website/Frontend_Finance_Web

composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan storage:link
npm ci
```

Di PowerShell, gunakan `Copy-Item .env.example .env` dan `New-Item -ItemType File database/database.sqlite`.

## Menjalankan

Buka dua terminal di `Frontend_Finance_Web`:

```bash
php artisan serve     # http://127.0.0.1:8000
npm run dev           # Vite dev server
```

Buka <http://127.0.0.1:8000> lalu klik **Daftar** untuk membuat akun.

### Service Go (opsional)

```bash
cd Backend_Go
cp .env.example .env      # isi GEMINI_API_KEY dan kredensial MySQL
go run ./cmd/server       # http://127.0.0.1:8080
```

## Environment Variables

| Lokasi | Variabel | Keterangan |
|---|---|---|
| `Frontend_Finance_Web/.env` | `APP_KEY` | Dibuat oleh `php artisan key:generate` |
| | `APP_URL`, `APP_ENV`, `APP_DEBUG` | Base URL, lingkungan, dan mode debug |
| | `DB_CONNECTION` | `sqlite` (default) atau `mysql` |
| | `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Hanya jika memakai MySQL |
| `Backend_Go/.env` | `GEMINI_API_KEY` | Wajib; ambil dari [Google AI Studio](https://aistudio.google.com/) |
| | `DB_USER`, `DB_PASSWORD`, `DB_HOST`, `DB_PORT`, `DB_NAME` | Koneksi MySQL |

Jangan meng-commit file `.env`.

## Perintah Berguna

Jalankan di `Frontend_Finance_Web`:

```bash
php artisan test      # 23 test (unit dan feature)
npm run build         # build asset production
```

## Dokumentasi

Dokumentasi lengkap (arsitektur, struktur proyek, testing, deployment, troubleshooting, dan keterbatasan) ada di repo dokumentasi:
<https://github.com/reynardwijaya/Reynard-Documentation>

Panduan design system (token, komponen, aturan tema): [`Frontend_Finance_Web/docs/design-system.md`](Frontend_Finance_Web/docs/design-system.md).
