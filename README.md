
# Rado-App — To-Do List & Personal Task Manager

## Deskripsi

Rado-App adalah aplikasi web To-Do List yang dirancang untuk membantu pengguna mengatur, mencatat, dan menyelesaikan tugas sehari-hari secara lebih terstruktur.

Aplikasi ini memiliki desain modern, minimalis, dan aesthetic dengan dominasi warna biru. Rado-App dikembangkan menggunakan Laravel, Laravel Breeze, Blade, dan MySQL.

## Fitur Aplikasi

- Registrasi akun pengguna.
- Login dan logout.
- Dashboard statistik tugas.
- Menambahkan tugas baru.
- Melihat daftar tugas.
- Mengedit informasi tugas.
- Menghapus tugas.
- Mengubah status tugas.
- Mengatur prioritas tugas: rendah, sedang, dan tinggi.
- Mengatur tanggal dan waktu tenggat tugas.
- Mengelompokkan tugas berdasarkan kategori.
- Mencari dan memfilter tugas.
- Melihat tugas yang sudah selesai.
- Melihat tugas yang mendekati atau melewati tenggat.
- Mengelola profil pengguna.
- Tampilan responsif untuk laptop dan HP.

## Teknologi yang Digunakan

- **Backend:** Laravel 13
- **Autentikasi:** Laravel Breeze
- **Template:** Blade
- **Frontend:** HTML5, CSS3, dan JavaScript
- **Database:** MySQL
- **PHP:** 8.3 atau lebih baru sesuai kebutuhan dependensi
- **Package Manager PHP:** Composer
- **Frontend Build Tool:** Vite
- **Lingkungan Pengembangan:** Laragon
- **Code Editor:** Visual Studio Code

## Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan perangkat telah memiliki:

1. PHP versi yang kompatibel dengan proyek.
2. Composer.
3. Node.js dan npm.
4. MySQL.
5. Laragon atau lingkungan pengembangan Laravel lainnya.
6. Visual Studio Code atau editor kode lainnya.

## Instalasi dan Konfigurasi

### 1. Masuk ke Folder Proyek

Buka terminal dan jalankan:

```bash
cd C:\laragon\www\rado-app
```

### 2. Instal Dependensi Laravel

```bash
composer install
```

### 3. Konfigurasi File Environment

Jika file `.env` belum tersedia, salin file `.env.example` menjadi `.env`:

```bash
copy .env.example .env
```

Jika `.env` sudah tersedia, gunakan file tersebut tanpa menimpanya.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Buat Database MySQL

Buka Laragon, aktifkan MySQL, lalu buat database dengan nama:

```text
rado_app
```

Sesuaikan konfigurasi database pada file `.env`:

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

Sesuaikan username dan password dengan konfigurasi MySQL di komputer masing-masing.

### 6. Jalankan Migration

```bash
php artisan migrate
```

Perintah ini digunakan untuk membuat tabel database berdasarkan migration yang tersedia.

Jika proyek menyediakan seeder dan kamu ingin mengisi data awal, periksa isi seeder terlebih dahulu sebelum menjalankannya.

```bash
php artisan db:seed
```

### 7. Instal Dependensi Frontend

```bash
npm install
```

### 8. Build Aset Frontend

```bash
npm run build
```

### 9. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser dan akses alamat berikut:

http://127.0.0.1:8000

## Struktur Folder

```text
rado-app/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── tasks/
│       ├── categories/
│       └── dashboard.blade.php
├── routes/
│   └── web.php
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

## Alur Penggunaan Aplikasi

1. Pengguna membuka halaman Rado-App.
2. Pengguna membuat akun atau login.
3. Pengguna masuk ke dashboard.
4. Pengguna menambahkan tugas beserta deskripsi, kategori, prioritas, dan tenggat waktu.
5. Pengguna dapat melihat, mengedit, mencari, memfilter, dan menghapus tugas.
6. Pengguna memperbarui status tugas ketika mulai mengerjakan atau menyelesaikannya.
7. Dashboard menampilkan ringkasan progres berdasarkan data tugas pengguna.

## Keamanan Aplikasi

Rado-App dirancang untuk menggunakan fitur keamanan Laravel, meliputi:

- Autentikasi pengguna.
- Password hashing.
- Validasi input.
- Perlindungan CSRF.
- Pembatasan akses berdasarkan kepemilikan data.
- Pengelolaan data menggunakan Eloquent ORM.

Implementasi setiap fitur keamanan harus dipastikan tersedia dan berfungsi pada kode aplikasi.

## Tujuan Pengembangan

Rado-App bertujuan membantu pengguna meningkatkan produktivitas melalui pengelolaan tugas yang sederhana, terstruktur, dan mudah digunakan.

Dengan tampilan biru yang nyaman dilihat serta fitur pengelolaan tugas yang terintegrasi, Rado-App diharapkan dapat menjadi alat bantu untuk mengatur aktivitas sehari-hari.

## Informasi Proyek

- **Nama aplikasi:** Rado-App
- **Jenis aplikasi:** To-Do List dan Personal Task Manager
- **Framework:** Laravel
- **Template frontend:** Blade
- **Database:** MySQL
- **Bahasa antarmuka:** Bahasa Indonesia
