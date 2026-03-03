<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

# 📋 Aplikasi Kuesioner Program Prioritas KNMP

> **Kawasan Nelayan Maju dan Prioritas (KNMP)** — Sistem aplikasi kuesioner dan monitoring untuk program prioritas KNMP, Direktorat Jenderal Perikanan Tangkap, Kementerian Kelautan dan Perikanan (KKP).

---

## 🖥️ System Environment

### Tech Stack

| Layer                     | Teknologi           | Versi       |
| ------------------------- | ------------------- | ----------- |
| **Backend Framework**     | Laravel             | ^12.0       |
| **Bahasa Pemrograman**    | PHP                 | ^8.2        |
| **Database**              | MySQL               | 5.7+ / 8.0+ |
| **Frontend CSS**          | Tailwind CSS        | ^4.0        |
| **Build Tool**            | Vite                | ^7.0        |
| **Vite Plugin**           | laravel-vite-plugin | ^2.0        |
| **HTTP Client**           | Axios               | ^1.11       |
| **Package Manager (PHP)** | Composer            | 2.x         |
| **Package Manager (JS)**  | NPM                 | 10.x+       |

### Paket Tambahan (Dependencies)

| Paket                     | Kegunaan                          |
| ------------------------- | --------------------------------- |
| `barryvdh/laravel-dompdf` | Generasi laporan PDF              |
| `maatwebsite/excel`       | Ekspor & impor data ke/dari Excel |
| `laravel/tinker`          | REPL interaktif untuk debugging   |

### Dev Dependencies

| Paket             | Kegunaan                       |
| ----------------- | ------------------------------ |
| `laravel/pail`    | Real-time log viewer           |
| `laravel/pint`    | PHP code style fixer           |
| `laravel/sail`    | Docker development environment |
| `phpunit/phpunit` | Unit & feature testing         |
| `fakerphp/faker`  | Data dummy generator           |
| `mockery/mockery` | Mocking library untuk testing  |

---

## ⚙️ Konfigurasi Environment

Aplikasi menggunakan file `.env` untuk konfigurasi. Salin `.env.example` ke `.env` dan sesuaikan:

```env
# Aplikasi
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database (MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=program-prioritas-knmp
DB_USERNAME=root
DB_PASSWORD=

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

---

## 🚀 Instalasi & Setup

### Prasyarat (Prerequisites)

Pastikan sistem Anda sudah memiliki:

- ✅ **PHP** >= 8.2 (dengan ekstensi: `mbstring`, `xml`, `curl`, `mysql`, `zip`, `gd`)
- ✅ **Composer** >= 2.x
- ✅ **Node.js** >= 20.x & **NPM** >= 10.x
- ✅ **MySQL** >= 5.7 atau 8.0+
- ✅ **Git**

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/YOUR_USERNAME/program-prioritas-knmp.git
cd program-prioritas-knmp

# 2. Install PHP dependencies
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi database di file .env
#    Sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Jalankan migrasi database
php artisan migrate

# 7. Jalankan seeder (opsional, untuk data awal)
php artisan db:seed

# 8. Install Node.js dependencies
npm install

# 9. Build assets
npm run build
```

### Menjalankan Aplikasi (Development)

```bash
# Opsi 1: Jalankan semua service sekaligus
composer dev

# Opsi 2: Jalankan secara terpisah
php artisan serve          # Server Laravel (http://localhost:8000)
npm run dev                # Vite dev server (hot reload)
php artisan queue:listen   # Queue worker
```

---

## 📁 Struktur Proyek

```
program-prioritas-knmp/
├── app/
│   ├── Console/          # Artisan commands
│   ├── Exports/          # Export classes (Excel/PDF) — 15 file
│   ├── Http/
│   │   ├── Controllers/  # Controller logic — 31 file
│   │   ├── Middleware/    # Custom middleware — 2 file
│   │   └── Requests/     # Form request validation
│   ├── Imports/          # Import classes (Excel) — 11 file
│   ├── Models/           # Eloquent models — 39 file
│   ├── Providers/        # Service providers
│   └── Traits/           # Reusable traits
├── database/
│   ├── migrations/       # Database migrations — 55 file
│   └── seeders/          # Database seeders — 18 file
├── resources/
│   ├── css/              # Stylesheet (Tailwind CSS)
│   ├── js/               # JavaScript assets
│   └── views/            # Blade templates
├── routes/
│   ├── web.php           # Route definisi web
│   └── console.php       # Console routes
├── public/               # Public assets
├── config/               # Konfigurasi aplikasi
├── storage/              # File storage & logs
├── tests/                # Unit & feature tests
├── composer.json         # PHP dependencies
├── package.json          # Node.js dependencies
├── vite.config.js        # Vite configuration
└── tailwind.config.js    # Tailwind CSS configuration
```

---

## 📊 Fitur Utama

| Fitur                       | Deskripsi                                                        |
| --------------------------- | ---------------------------------------------------------------- |
| **Manajemen Responden**     | Input dan kelola data responden kuesioner                        |
| **Kuesioner Multi-Bagian**  | Informasi umum, usaha, pemasaran, pendapatan, sosial kelembagaan |
| **Progres KNMP**            | Monitoring progres pembangunan kawasan nelayan                   |
| **Komponen & Anggaran**     | Pengelolaan komponen dan anggaran KNMP                           |
| **Kendala & Tindak Lanjut** | Pencatatan kendala dan progres penyelesaian                      |
| **Ekspor Data**             | Laporan dalam format Excel dan PDF                               |
| **Impor Data**              | Impor data dari file Excel                                       |
| **Activity Log**            | Pencatatan aktivitas pengguna                                    |
| **Role Management**         | Manajemen hak akses berdasarkan peran                            |
| **Dashboard**               | Ringkasan data dan statistik                                     |

---

## 🧪 Testing

```bash
# Jalankan semua test
php artisan test

# Atau menggunakan PHPUnit langsung
./vendor/bin/phpunit
```

---

## 📝 Dokumentasi Tambahan

- [Dokumentasi Edit Form Prefill](EDIT_FORM_PREFILL_DOCUMENTATION.md)
- [Dokumentasi Edit Responden](EDIT_RESPONDEN_DOCUMENTATION.md)

---

## 📄 Lisensi

Proyek ini menggunakan framework [Laravel](https://laravel.com) yang dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).
