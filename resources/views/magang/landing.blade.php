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
    <!-- CSS Kustom Universal -->
    <link rel="stylesheet" href="{{ asset('css/portal-auth.css') }}">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 50px 0 90px 0;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
        }
        .feature-card {
            border: none;
            border-radius: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            background: #ffffff;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .footer-custom-dark {
            background-color: #000000;
            color: #ffffff;
            padding: 60px 0 40px 0;
            margin-top: 80px;
        }
    </style>
</head>
<body class="bg-white">

    <!-- NAVBAR / HEADER -->
    <nav class="navbar navbar-expand-lg navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="{{ route('magang.landing') }}" style="font-size: 1rem;">
                <i class="fa-solid fa-building-columns"></i> SAMSAT KBB | Magang
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link text-white small fw-medium d-none d-sm-block" href="#fitur">Fitur Utama</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('magang.login') }}" class="btn text-white px-3 py-1.5 rounded-pill small fw-medium" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Login Peserta
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section text-white">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="badge bg-white text-primary px-3 py-1.5 rounded-pill fw-semibold mb-3 small shadow-sm">
                        <i class="fa-solid fa-circle-check me-1"></i> Resmi & Terintegrasi
                    </span>
                    <h1 class="fw-bold mb-3" style="font-size: 2.3rem; line-height: 1.25;">
                        Portal Monitoring & Absensi Magang SAMSAT KBB
                    </h1>
                    <p class="text-white-50 mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                        Platform digital modern untuk mengelola kehadiran, aktivitas harian, serta rekapitulasi data peserta magang di lingkungan Kantor SAMSAT Kabupaten Bandung Barat secara transparan dan akurat.
                    </p>
                    <div>
                        <a href="{{ route('magang.login') }}" class="btn bg-white text-primary fw-semibold px-4 py-2.5 rounded-pill shadow-sm small text-decoration-none d-inline-flex align-items-center">
                            Masuk <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="p-4 rounded-4 text-white text-center text-sm-start" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                        <div class="mb-3">
                            <i class="fa-solid fa-laptop-code text-white fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-white">Sistem Absensi Digital</h5>
                        <p class="text-white-50 small mb-0" style="font-size: 0.85rem;">
                            Cepat, aman, dan mudah diakses kapan saja untuk kebutuhan laporan magang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FITUR UNGGULAN SECTION -->
    <section id="fitur" class="py-5" style="margin-top: -30px;">
        <div class="container py-3">
            <div class="text-center mb-5">
                <h3 class="fw-bold text-dark mb-1" style="font-size: 1.5rem;">Fitur Unggulan Sistem</h3>
                <p class="text-muted small">Dirancang khusus untuk mengoptimalkan manajemen administrasi magang</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="card feature-card p-4 h-100 border border-light">
                        <div class="mb-3 text-primary fs-4">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Absensi Real-Time</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.85rem;">
                            Pencatatan waktu kehadiran peserta magang tercatat secara presisi langsung ke dalam database.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 h-100 border border-light">
                        <div class="mb-3 text-primary fs-4">
                            <i class="fa-solid fa-file-excel"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Export Data Otomatis</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.85rem;">
                            Admin dapat merekap dan mengunduh laporan kehadiran peserta magang dalam format Excel dengan satu klik.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 h-100 border border-light">
                        <div class="mb-3 text-primary fs-4">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Keamanan Terjamin</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.85rem;">
                            Sistem terlindungi dengan autentikasi akun yang aman guna menjaga kerahasiaan data instansi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer-custom-dark">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <h5 class="fw-bold text-white mb-3">Media Sosial</h5>
                    <div class="d-flex flex-column gap-2 small text-white-50">
                        <div>
                            <a href="https://www.instagram.com/samsat.kbb/" target="_blank" class="text-white-50 text-decoration-none d-flex align-items-center gap-2">
                                <i class="fa-brands fa-instagram text-danger"></i> Ikuti Kami di Instagram
                            </a>
                        </div>
                        <div>
                            <a href="https://www.tiktok.com/@samsat.kbb" target="_blank" class="text-white-50 text-decoration-none d-flex align-items-center gap-2">
                                <i class="fa-brands fa-tiktok text-info"></i> Ikuti Kami di TikTok
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <h5 class="fw-bold text-white mb-3">Kontak</h5>
                    <p class="fw-bold text-white mb-2" style="font-size: 0.95rem;">SAMSAT KABUPATEN BANDUNG BARAT</p>
                    <p class="small text-white-50 mb-2" style="line-height: 1.5;">
                        <a href="https://www.google.com/maps/search/?api=1&query=Kantor+Bersama+Samsat+Kabupaten+Bandung+Barat+Gadobangkong" target="_blank" class="text-white-50 text-decoration-none d-flex align-items-start gap-2">
                            <i class="fa-solid fa-location-dot text-danger mt-1"></i>
                            <span>Jl. Raya Gadobangkong No.203, Cimareme, Kec. Ngamprah, Kabupaten Bandung Barat, Jawa Barat 40552</span>
                        </a>
                    </p>
                    <p class="small text-white-50 mb-0">
                        WhatsApp Chatbot 081122301818<br>
                        bapenda@jabarprov.go.id
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>