<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Peserta Magang - SAMSAT KBB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand fw-bold text-white" href="#">
                    <i class="fa-solid fa-building-columns me-2"></i> SAMSAT KBB - Portal Magang
                </a>
                
                <div class="ms-auto d-flex align-items-center gap-2">
                    <a href="{{ route('magang.landing') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
                        <i class="fa-solid fa-house me-1"></i> Beranda
                    </a>
                    <a href="{{ route('magang.login') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                    </a>
                </div>
            </div>
        </nav>

        <div class="main-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-5">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger bg-danger text-white border-0 py-2 small rounded-3 mb-3">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="glass-card shadow-sm">
                            <div class="text-center mb-4">
                                <h4 class="fw-bold mb-1 text-dark">Registrasi Akun</h4>
                                <p class="small text-muted mb-0">SAMSAT Kabupaten Bandung Barat</p>
                            </div>

                            <form action="{{ route('magang.register.store') }}" method="POST">
                                @csrf
                                
                                <div class="mb-3 position-relative">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text-glass"><i class="fa-solid fa-user"></i></span>
                                        <input type="text" class="form-control form-control-glass" name="nama" placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
                                    </div>
                                </div>

                                <div class="mb-3 position-relative">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text-glass"><i class="fa-solid fa-building"></i></span>
                                        <input type="text" class="form-control form-control-glass" name="asal_instansi" placeholder="Asal Instansi / Sekolah / Kampus" value="{{ old('asal_instansi') }}" required>
                                    </div>
                                </div>

                                <div class="mb-3 position-relative">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text-glass"><i class="fa-solid fa-envelope"></i></span>
                                        <input type="email" class="form-control form-control-glass" name="email" placeholder="Alamat Email" value="{{ old('email') }}" required>
                                    </div>
                                </div>

                                <div class="mb-4 position-relative">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text-glass"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" class="form-control form-control-glass" name="password" placeholder="Password (Min. 6 Karakter)" required>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-glass shadow-sm">DAFTAR SEKARANG</button>
                                </div>
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