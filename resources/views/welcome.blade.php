<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rado-App - Personal Task Manager</title>

    <meta name="description" content="Rado-App membantu mengatur tugas, menjaga fokus, dan menyelesaikan hal-hal penting setiap hari.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Landing CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>

<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="navbar-container">

            <a href="{{ url('/') }}" class="brand">
                <div class="brand-icon">
                    <i class="bi bi-check2-square"></i>
                </div>

                <div class="brand-text">
                    <span class="brand-name">
                        Rado<span>-App</span>
                    </span>

                    <small>TO-DO & TASK MANAGER</small>
                </div>
            </a>

            <div class="navbar-actions">

                <button type="button"
                        class="code-guide-btn"
                        id="openCodeGuide">
                    <i class="bi bi-code-slash"></i>
                    <span>Kode Laravel 11</span>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="btn-dashboard">
                        <span>Buka Dashboard</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-login">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}" class="btn-primary btn-nav">
                        Mulai Sekarang
                    </a>
                @endauth

            </div>

            <button class="mobile-menu-toggle" id="mobileMenuToggle"
                    type="button" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>

        </div>
    </header>


    <!-- MOBILE MENU -->
    <div class="mobile-menu" id="mobileMenu">

        <button type="button" id="mobileCodeGuide">
            <i class="bi bi-code-slash"></i>
            Kode Laravel 11
        </button>

        @auth
            <a href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                Buka Dashboard
            </a>
        @else
            <a href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right"></i>
                Masuk
            </a>

            <a href="{{ route('register') }}">
                <i class="bi bi-person-plus"></i>
                Mulai Sekarang
            </a>
        @endauth

    </div>


    <!-- MAIN -->
    <main>

        <!-- HERO SECTION -->
        <section class="hero-section">

            <div class="hero-content">

                <div class="hero-badge">
                    <i class="bi bi-stars"></i>

                    <span>
                        Arsitektur Laravel Breeze & Blade
                        <span class="badge-dot">•</span>
                        Database MySQL
                    </span>
                </div>

                <h1>
                    Atur Harimu,
                    <br>
                    <span class="gradient-text">
                        Raih Tujuanmu.
                    </span>
                </h1>

                <p class="hero-description">
                    Satu tempat untuk mengatur tugas, menjaga fokus,
                    dan menyelesaikan hal-hal penting setiap hari
                    dengan tampilan aesthetic biru yang menenangkan.
                </p>


                <!-- HERO BUTTON -->
                <div class="hero-buttons">

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary btn-hero">
                            <span>
                                Lanjutkan ke Dashboard
                                ({{ explode(' ', auth()->user()->name)[0] }})
                            </span>

                            <i class="bi bi-arrow-right"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary btn-hero">
                            <span>Mulai Sekarang — Gratis</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>

                        <a href="{{ route('login') }}" class="btn-secondary btn-hero">
                            Masuk ke Akun
                        </a>
                    @endauth

                </div>


                <!-- TRUST INFORMATION -->
                <div class="hero-trust">

                    <div class="trust-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Keamanan CSRF & Auth Breeze</span>
                    </div>

                    <div class="trust-item">
                        <i class="bi bi-check-circle"></i>
                        <span>Isolasi Data Antar Pengguna</span>
                    </div>

                </div>

            </div>


            <!-- DASHBOARD PREVIEW -->
            <div class="dashboard-preview">

                <div class="preview-top-gradient"></div>

                <div class="preview-header">

                    <div class="preview-header-left">
                        <span class="window-dot red"></span>
                        <span class="window-dot yellow"></span>
                        <span class="window-dot green"></span>

                        <span class="preview-title">
                            Pratinjau Dashboard Rado-App
                        </span>
                    </div>

                    <span class="live-badge">
                        Live Interactive UI
                    </span>

                </div>


                <!-- STATISTICS -->
                <div class="preview-stats">

                    <div class="stat-card stat-total">
                        <span>Total Tugas</span>
                        <strong>6</strong>
                    </div>

                    <div class="stat-card stat-today">
                        <span>Hari Ini</span>
                        <strong>3</strong>
                    </div>

                    <div class="stat-card stat-pending">
                        <span>Belum Selesai</span>
                        <strong>5</strong>
                    </div>

                    <div class="stat-card stat-completed">
                        <span>Tugas Selesai</span>
                        <strong>1</strong>
                    </div>

                </div>


                <!-- TASK LIST -->
                <div class="preview-task-list">

                    <div class="preview-task">

                        <div class="task-left">

                            <div class="task-checkbox"></div>

                            <div class="task-information">

                                <p>
                                    Menyelesaikan Laporan Praktikum Pemrograman Web
                                </p>

                                <span>
                                    Kuliah
                                    <span>•</span>
                                    Hari Ini, 14:00 WIB
                                </span>

                            </div>

                        </div>

                        <span class="priority priority-high">
                            Tinggi
                        </span>

                    </div>


                    <div class="preview-task">

                        <div class="task-left">

                            <div class="task-checkbox checked">
                                <i class="bi bi-check2"></i>
                            </div>

                            <div class="task-information">

                                <p class="task-done">
                                    Lari pagi 30 menit & hidrasi 2 liter
                                </p>

                                <span>
                                    Kesehatan
                                    <span>•</span>
                                    Selesai
                                </span>

                            </div>

                        </div>

                        <span class="priority priority-completed">
                            Selesai
                        </span>

                    </div>

                </div>

            </div>

        </section>


        <!-- FEATURES SECTION -->
        <section class="features-section" id="fitur">

            <div class="features-container">

                <div class="features-heading">

                    <h2>
                        Fitur Unggulan untuk Keseharian
                        yang Terstruktur
                    </h2>

                    <p>
                        Didesain khusus untuk mahasiswa, profesional,
                        dan siapa saja yang ingin hidup lebih teratur
                        dan bebas dari stres tugas menumpuk.
                    </p>

                </div>


                <div class="features-grid">

                    <!-- FEATURE 1 -->
                    <article class="feature-card">

                        <div class="feature-icon icon-blue">
                            <i class="bi bi-check2-square"></i>
                        </div>

                        <h3>Manajemen Prioritas Dinamis</h3>

                        <p>
                            Kelompokkan tugas berdasarkan tingkat urgensi
                            Tinggi, Sedang, dan Rendah dengan palet warna
                            visual yang memudahkan fokus.
                        </p>

                    </article>


                    <!-- FEATURE 2 -->
                    <article class="feature-card">

                        <div class="feature-icon icon-navy">
                            <i class="bi bi-calendar3"></i>
                        </div>

                        <h3>Pelacakan Tenggat & Waktu</h3>

                        <p>
                            Sistem otomatis mendeteksi tugas Hari Ini,
                            Besok, Minggu Depan, hingga peringatan tugas
                            yang Melewati Tenggat (Terlambat).
                        </p>

                    </article>


                    <!-- FEATURE 3 -->
                    <article class="feature-card">

                        <div class="feature-icon icon-yellow">
                            <i class="bi bi-tag"></i>
                        </div>

                        <h3>Kategori Kustom & Warna</h3>

                        <p>
                            Organisir kegiatan Kuliah, Pekerjaan,
                            Pribadi, Belanja, dan buat kategori tak
                            terbatas dengan pemilih warna kustom.
                        </p>

                    </article>


                    <!-- FEATURE 4 -->
                    <article class="feature-card">

                        <div class="feature-icon icon-green">
                            <i class="bi bi-bar-chart-line"></i>
                        </div>

                        <h3>Statistik & Analisis Produktivitas</h3>

                        <p>
                            Pantau progress harian lewat persentase
                            penyelesaian dan kartu statistik yang selalu
                            terhubung langsung dengan database.
                        </p>

                    </article>

                </div>

            </div>

        </section>

    </main>


    <!-- FOOTER -->
    <footer class="footer">

        <div class="footer-container">

            <div class="footer-brand">

                <i class="bi bi-check2-square"></i>

                <strong>Rado-App</strong>

                <span>
                    • Personal Task Manager Aesthetic Biru
                </span>

            </div>

            <p>
                &copy; {{ date('Y') }} Rado-App.
                Dibuat dengan arsitektur Laravel Breeze & Blade.
            </p>

        </div>

    </footer>


    <!-- CODE GUIDE MODAL -->
    <div class="modal-overlay" id="codeGuideModal">

        <div class="code-modal">

            <button type="button" class="modal-close" id="closeCodeGuide"
                    aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="modal-icon">
                <i class="bi bi-code-slash"></i>
            </div>

            <h2>Rado-App Architecture</h2>

            <p>
                Rado-App dibangun menggunakan teknologi berikut:
            </p>

            <div class="technology-list">

                <div>
                    <i class="bi bi-check-circle-fill"></i>
                    Laravel 11
                </div>

                <div>
                    <i class="bi bi-check-circle-fill"></i>
                    Laravel Breeze Authentication
                </div>

                <div>
                    <i class="bi bi-check-circle-fill"></i>
                    Blade Template Engine
                </div>

                <div>
                    <i class="bi bi-check-circle-fill"></i>
                    HTML, CSS & JavaScript
                </div>

                <div>
                    <i class="bi bi-check-circle-fill"></i>
                    MySQL Database
                </div>

            </div>

            <button type="button" class="btn-primary modal-button"
                    id="closeCodeGuideBottom">
                Mengerti
            </button>

        </div>

    </div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('js/landing.js') }}"></script>

</body>
</html>
