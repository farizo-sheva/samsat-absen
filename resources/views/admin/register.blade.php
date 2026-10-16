<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin Baru - Portal Absensi Magang SAMSAT KBB</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Kustom Utama -->
     <link rel="stylesheet" href="{{ asset('css/portal-auth.css') }}">
</head>
<body>

    <div class="page-wrapper">
        <!-- HEADER / NAVBAR BIRU KHAS SAMSAT -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand fw-bold text-white" href="{{ route('admin.landing') }}">
                    <i class="fa-solid fa-shield-halved me-2"></i> SAMSAT KBB | Portal Admin
                </a>
                
                <!-- Tombol Navigasi di Kanan Atas (Beranda & Login) -->
                <div class="ms-auto d-flex align-items-center gap-2">
                    <a href="{{ route('admin.landing') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                        <i class="fa-solid fa-house me-1"></i> Beranda
                    </a>
                    <a href="{{ route('admin.login') }}" class="btn btn-light btn-sm text-primary fw-bold rounded-pill px-3 shadow-sm">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                    </a>
                </div>
            </div>
        </nav>

        <!-- KONTEN UTAMA (CARD REGISTRASI ADMIN DI TENGAH) -->
        <div class="container d-flex flex-column align-items-center justify-content-center my-auto py-4">
            <div class="col-md-6 col-lg-5">
                
                <div class="glass-card">
                    <!-- Icon / Avatar Registrasi -->
                    <div class="avatar-icon">
                        <i class="fa-solid fa-user-plus fa-2x"></i>
                    </div>
                    
                    <div class="text-center mb-4">
                        <h4 class="fw-bold mb-1">Registrasi Admin Baru</h4>
                        <p class="text-muted small">Wajib Memasukkan Token Rahasia Instansi</p>
                    </div>

                    <!-- Notifikasi Pesan Error atau Success -->
                    @if(session('success'))
                        <div class="alert alert-success text-center py-2 mb-3" style="font-size: 13px; border-radius: 8px;">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger text-center py-2 mb-3" style="font-size: 13px; border-radius: 8px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Form Registrasi Admin -->
                    <form action="{{ route('admin.register.submit') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label-custom">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass">
                                    <i class="fa-solid fa-id-card"></i>
                                </span>
                                <input type="text" name="name" class="form-control form-control-glass" placeholder="Masukkan nama lengkap" required autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Username</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" name="username" class="form-control form-control-glass" placeholder="Masukkan username" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Password (Minimal 6 karakter)</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control form-control-glass" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom text-danger fw-bold">Token Rahasia</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass border-danger">
                                    <i class="fa-solid fa-key text-danger"></i>
                                </span>
                                <input type="password" name="token" class="form-control form-control-glass border-danger" placeholder="Masukkan token rahasia..." required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-glass w-100 mb-2">
                            Daftar Akun Admin <i class="fa-solid fa-user-check ms-1"></i>
                        </button>
                    </form>
                    <!-- Teks "Sudah punya akun? Login di sini" sudah dihapus bersih -->
                </div>

            </div>
        </div>

        <!-- FOOTER BIRU -->
        <footer class="footer-custom text-center">
            <div class="container">
                <p class="mb-1 fw-semibold">&copy; {{ date('Y') }} SAMSAT Kabupaten Bandung Barat (KBB)</p>
                <p class="small mb-0" style="color: #cbd5e1;">Sistem Monitoring & Absensi Magang Terpadu</p>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>