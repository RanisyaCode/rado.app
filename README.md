# Rado-App — To-Do List & Personal Task Manager

## Deskripsi

Rado-App adalah aplikasi web manajemen tugas (*To-Do List*) yang dirancang untuk membantu pengguna mengatur kegiatan sehari-hari secara lebih terstruktur, praktis, dan produktif.

Aplikasi ini memiliki tampilan yang modern, minimalis, dan aesthetic dengan dominasi warna biru. Rado-App dikembangkan menggunakan Laravel dengan Laravel Breeze untuk autentikasi pengguna serta Blade sebagai template antarmuka.

## Fitur Utama

- **Autentikasi Pengguna:** Registrasi, login, dan logout menggunakan Laravel Breeze.
- **Dashboard:** Menampilkan ringkasan dan statistik tugas pengguna.
- **Manajemen Tugas:** Menambahkan, melihat, mengedit, dan menghapus tugas.
- **Status Tugas:** Mengelompokkan tugas menjadi belum selesai, sedang dikerjakan, dan selesai.
- **Prioritas Tugas:** Menentukan prioritas rendah, sedang, atau tinggi.
- **Tenggat Waktu:** Mengatur tanggal dan waktu penyelesaian tugas.
- **Kategori Tugas:** Mengelompokkan kegiatan berdasarkan kategori.
- **Pencarian dan Filter:** Memudahkan pengguna menemukan tugas tertentu.
- **Desain Responsif:** Tampilan yang menyesuaikan perangkat desktop, tablet, dan HP.

## Teknologi yang Digunakan

- PHP
- Laravel
- Laravel Breeze
- Blade Template Engine
- HTML5
- CSS3
- JavaScript
- MySQL
- Vite
- Laragon

## Persyaratan Sistem

Pastikan perangkat telah memiliki:

- PHP versi 8.3 atau lebih baru yang kompatibel dengan proyek.
- Composer.
- Node.js dan npm.
- MySQL.
- Laragon atau lingkungan pengembangan web yang setara.

## Instalasi dan Menjalankan Aplikasi

### 1. Clone atau buka proyek

Buka terminal dan masuk ke direktori proyek Rado-App.

```bash
cd C:\laragon\www\rado-app
```

### 2. Instal dependensi PHP

```bash
composer install
```

### 3. Konfigurasi environment

Salin file `.env.example` menjadi `.env` jika file `.env` belum tersedia.

```bash
copy .env.example .env
```

Jika file `.env` sudah tersedia, jangan menimpanya.

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Konfigurasi database

Buat database MySQL bernama `rado_app` melalui phpMyAdmin atau HeidiSQL.

Sesuaikan konfigurasi berikut pada file `.env`:

```env
APP_NAME=Rado-App
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rado-app
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan nama database, username, dan password dengan konfigurasi MySQL yang digunakan.

### 6. Jalankan migration

```bash
php artisan migrate
```

Jika proyek menyediakan seeder untuk data awal, jalankan sesuai kebutuhan.

```bash
php artisan db:seed
```

Jalankan seeder hanya jika sudah dipastikan aman untuk database yang digunakan.

### 7. Instal dependensi frontend

```bash
npm install
```

### 8. Build aset frontend

```bash
npm run build
```

Perintah ini menghasilkan aset frontend untuk digunakan oleh Laravel melalui Vite.

### 9. Jalankan aplikasi

```bash
php artisan serve
```

Buka browser dan akses:

http://127.0.0.1:8000

## Struktur Folder Utama

```text
rado-app/
├── app/
│   ├── Http/Controllers/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   └── web.php
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

## Tujuan Pengembangan

Rado-App dikembangkan sebagai aplikasi pengelolaan tugas yang mudah digunakan, memiliki antarmuka yang menarik, dan membantu pengguna meningkatkan produktivitas melalui pencatatan serta pemantauan penyelesaian tugas.

## Pengembang

**Nama Proyek:** Rado-App  
**Kategori:** Web Application — To-Do List  
**Framework:** Laravel  
**Template:** Blade  
**Database:** MySQL