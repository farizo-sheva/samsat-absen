<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Absensi Magang - SAMSAT KBB</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Kustom yang sudah kita buat -->
     <link rel="stylesheet" href="{{ asset('css/portal-auth.css') }}">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 90px 0;
            border-radius: 0 0 30px 30px;
        }
        .feature-card {
            border: none;
            border-radius: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-white">

    <!-- NAVBAR / HEADER -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="#">
                <i class="fa-solid fa-shield-halved me-2"></i> SAMSAT KBB | Magang
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link text-white fw-semibold" href="#fitur">Fitur Utama</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.login') }}" class="btn btn-light text-primary fw-bold px-4 rounded-pill shadow-sm">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Login Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION (Bagian Utama Sambutan) -->
    <section class="hero-section text-center text-lg-start">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <span class="badge bg-light text-primary fw-bold px-3 py-2 rounded-pill mb-3">
                        <i class="fa-solid fa-circle-check me-1"></i> Resmi & Terintegrasi
                    </span>
                    <h1 class="display-4 fw-bold mb-3">Portal Monitoring & Absensi Magang SAMSAT KBB</h1>
                    <p class="lead mb-4 text-light" style="opacity: 0.9;">
                        Platform digital modern untuk mengelola kehadiran, aktivitas harian, serta rekapitulasi data peserta magang di lingkungan Kantor SAMSAT Kabupaten Bandung Barat secara transparan dan akurat.
                    </p>
                    <div>
                        <a href="{{ route('admin.login') }}" class="btn btn-light btn-lg text-primary fw-bold px-4 me-2 rounded-pill shadow">
                            Masuk ke Dashboard <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <div class="p-4 bg-white bg-opacity-10 rounded-4 backdrop-blur shadow-lg border border-light border-opacity-25">
                        <i class="fa-solid fa-laptop-code fa-5x text-white mb-3"></i>
                        <h4 class="fw-bold text-white">Sistem Absensi Digital</h4>
                        <p class="small text-light mb-0">Cepat, aman, dan mudah diakses kapan saja untuk kebutuhan laporan magang.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FITUR UNGGULAN SECTION -->
    <section id="fitur" class="py-5 my-4">
        <div class="container py-3">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">Fitur Unggulan Sistem</h2>
                <p class="text-muted">Dirancang khusus untuk mengoptimalkan manajemen administrasi magang</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4 h-100 bg-light">
                        <div class="avatar-icon mb-3">
                            <i class="fa-solid fa-clock-rotate-left fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Absensi Real-Time</h5>
                        <p class="text-muted small mb-0">Pencatatan waktu kehadiran peserta magang tercatat secara presisi langsung ke dalam database.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 h-100 bg-light">
                        <div class="avatar-icon mb-3">
                            <i class="fa-solid fa-file-excel fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Export Data Otomatis</h5>
                        <p class="text-muted small mb-0">Admin dapat merekap dan mengunduh laporan kehadiran peserta magang dalam format Excel dengan satu klik.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 h-100 bg-light">
                        <div class="avatar-icon mb-3">
                            <i class="fa-solid fa-shield-halved fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Keamanan Terjamin</h5>
                        <p class="text-muted small mb-0">Sistem terlindungi dengan autentikasi admin yang aman guna menjaga kerahasiaan data instansi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer-custom text-center">
        <div class="container">
            <p class="mb-1 fw-semibold">&copy; {{ date('Y') }} SAMSAT Kabupaten Bandung Barat (KBB)</p>
            <p class="small mb-0" style="color: #93c5fd;">Sistem Monitoring & Absensi Magang Terpadu</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>