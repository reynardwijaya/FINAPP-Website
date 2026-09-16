# Finapp 💰

Finapp adalah aplikasi web pencatatan dan analisis keuangan yang dirancang khusus untuk pelaku UMKM. Alih-alih pusing dengan spreadsheet, pemilik usaha kecil bisa mencatat transaksi, memantau kondisi keuangan, dan mendapat rekomendasi otomatis hanya dalam beberapa klik.

- 📊 Dashboard yang merangkum kondisi keuangan usaha secara sekilas
- 💸 Pencatatan transaksi pemasukan & pengeluaran per kategori
- 🧮 Analisis keuangan otomatis dengan rekomendasi actionable berbasis data transaksi
- 📈 Laporan & statistik keuangan untuk melihat tren dari waktu ke waktu
- 📚 Artikel edukasi finansial khusus untuk pelaku UMKM

## Tech Stack

| Layer | Teknologi |
|---|---|
| Web Framework | Laravel 11 (PHP 8.2) |
| Frontend / UI | Blade Templates, Alpine.js, Tailwind CSS 4 |
| Build Tool | Vite 6 |
| Visualisasi Data | Chart.js |
| Database | MySQL / SQLite |
| Backend API (AI Service) | Go 1.23 (net/http) |
| AI Model | Google Gemini API |

## Environment Variables

**Frontend_Finance_Web** (`.env`, salin dari `.env.example`):
| Variabel | Keterangan |
|---|---|
| `APP_KEY` | Kunci enkripsi Laravel, generate otomatis via `php artisan key:generate` |
| `APP_URL` | Base URL aplikasi saat development/production |
| `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Kredensial koneksi database (MySQL lokal via XAMPP, atau biarkan default sqlite) |

**Backend_Go** (`.env`, salin dari `.env.example`):
| Variabel | Keterangan |
|---|---|
| `DB_USER`, `DB_PASSWORD`, `DB_HOST`, `DB_PORT`, `DB_NAME` | Kredensial koneksi MySQL |
| `GEMINI_API_KEY` | API key untuk Google Gemini, ambil dari [Google AI Studio](https://aistudio.google.com/) > API Keys |

## Cara Instalasi & Menjalankan

Prasyarat:
- PHP >= 8.2 & Composer
- Node.js >= 18 & npm
- Go >= 1.23
- MySQL (mis. via XAMPP) atau gunakan default SQLite
- API key Google Gemini (untuk fitur analisis AI)

```bash
# 1. Clone repository
git clone https://github.com/reynardwijaya/FINAPP-Website.git
cd FINAPP-Website

# 2. Setup web app (Laravel)
cd Frontend_Finance_Web
composer install
cp .env.example .env
php artisan key:generate
# sesuaikan kredensial DB di .env, lalu:
php artisan migrate
npm install
npm run dev

# 3. Jalankan server Laravel (di terminal terpisah)
php artisan serve

# 4. Setup Go backend (opsional, service AI terpisah)
cd ../Backend_Go
cp .env.example .env
# isi GEMINI_API_KEY dan kredensial DB di .env
go run ./cmd/server
```

Script tambahan yang berguna:

```bash
npm run build        # build asset frontend untuk production (Frontend_Finance_Web)
php artisan test     # jalankan test suite Laravel (Frontend_Finance_Web)
go build ./cmd/server # build binary Go backend (Backend_Go)
```
