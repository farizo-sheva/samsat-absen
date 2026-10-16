<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Peserta Magang - SAMSAT KBB</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Terpusat Magang Auth -->
    <link rel="stylesheet" href="{{ asset('css/portal-auth.css') }}">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 40px 0;
        }
    </style>
</head>
<body class="bg-light">

    <div class="page-wrapper">
        
        <!-- Navbar Atas -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand fw-bold text-white" href="#">
                    <i class="fa-solid fa-building-columns me-2"></i> SAMSAT KBB - Portal Magang
                </a>
                
                <div class="ms-auto d-flex align-items-center gap-2">
                    <a href="{{ route('magang.landing') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
                        <i class="fa-solid fa-house me-1"></i> Beranda
                    </a>
                    <a href="{{ route('magang.register') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
                        <i class="fa-solid fa-user-plus me-1"></i> Daftar Akun
                    </a>
                </div>
            </div>
        </nav>

        <!-- Konten Utama (Form Login) -->
        <div class="main-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        
                        <div class="glass-card shadow-sm">
                            
                            <div class="avatar-icon shadow-sm">
                                <i class="fa-solid fa-user-graduate fs-3"></i>
                            </div>

                            <div class="text-center mb-4">
                                <h4 class="fw-bold text-dark">Login Peserta Magang</h4>
                                <p class="text-muted small mb-0">Masukkan akun terdaftar untuk melakukan absensi</p>
                            </div>

                            @if(request()->has('error') || session('error'))
                                <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ request('error') ?? session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('success_login'))
                                <div class="alert alert-success alert-dismissible fade show py-2 small" role="alert">
                                    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success_login') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('magang.login.submit') }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="form-label-custom">Email atau Identitas</label>
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text-glass"><i class="fa-solid fa-id-card"></i></span>
                                        <input type="text" name="email" class="form-control form-control-glass" placeholder="Masukkan email / identitas" required autofocus>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label-custom">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text-glass"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="password" class="form-control form-control-glass" placeholder="••••••••" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-glass w-100 shadow-sm">
                                    <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer style="background-color: #000000; color: #ffffff; padding: 50px 0 40px 0;">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <h5 class="fw-bold text-white mb-3" style="font-size: 1.1rem;">Media Sosial</h5>
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
                        <h5 class="fw-bold text-white mb-3" style="font-size: 1.1rem;">Kontak</h5>
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

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>