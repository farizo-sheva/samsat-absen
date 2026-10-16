<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Scan Absen - SAMSAT KBB</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- CSS Terpusat Portal Auth & Dashboard Magang -->
    <link rel="stylesheet" href="{{ asset('css/portal-auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-magang.css') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <div class="page-wrapper">
        
        <!-- Navbar Atas -->
        <nav class="navbar navbar-expand-lg navbar-custom px-4">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="#">
                    <i class="fa-solid fa-building-columns"></i> 
                    <span>SAMSAT KBB - Portal Magang</span>
                </a>
                
                <div class="ms-auto d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle bg-dark bg-opacity-25 px-3 py-1.5 rounded-pill border border-white border-opacity-10" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-graduate me-2 text-warning fs-5"></i>
                            <div class="text-start lh-1">
                                <span class="fw-semibold d-block small" style="font-size: 0.85rem;">Halo, {{ $peserta->nama ?? session('magang_nama') }}</span>
                                <span class="text-white-50" style="font-size: 0.7rem;">{{ $peserta->asal_instansi ?? '-' }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow text-small" aria-labelledby="dropdownUser1">
                            <li>
                                <form action="{{ route('magang.logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Konten Utama -->
        <div class="main-content py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        
                        <!-- Bar Jam Digital & Status Hari Ini -->
                        <div class="row g-3 mb-3">
                            <!-- Kolom Jam Digital Live -->
                            <div class="col-md-6">
                                <div class="dashboard-card p-3 d-flex align-items-center gap-3 h-100 shadow-sm mb-0">
                                    <div class="bg-primary bg-opacity-10 text-primary p-2.5 rounded-3 fs-4">
                                        <i class="fa-solid fa-clock"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block" style="font-size: 0.75rem;">Waktu Real-time</span>
                                        <h6 class="fw-bold text-dark mb-0" id="live-clock">--:--:--</h6>
                                        <small class="text-secondary" style="font-size: 0.7rem;" id="live-date">Memuat...</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Status Absen Hari Ini -->
                            <div class="col-md-6">
                                <div class="dashboard-card p-3 d-flex align-items-center gap-3 h-100 shadow-sm mb-0">
                                    @php
                                        $currentBatas = \DB::table('settings')->where('key_name', 'batas_jam_masuk')->value('key_value') ?? '08:00';
                                    @endphp

                                    @if(isset($absenHariIni) &&$absenHariIni)
                                        @php
                                            $jamMasuk =$absenHariIni->jam_masuk;
                                            $statusAbsen =$absenHariIni->status;
                                            $isTelat = ($statusAbsen == 'Terlambat');
                                        @endphp
                                        <div class="bg-{{ $isTelat ? 'danger' : 'success' }} bg-opacity-10 text-{{ $isTelat ? 'danger' : 'success' }} p-2.5 rounded-3 fs-4">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                        <div>
                                            <span class="text-muted small d-block" style="font-size: 0.75rem;">Status Hari Ini</span>
                                            @if($isTelat)
                                                <span class="badge bg-danger mb-1">Terlambat</span>
                                            @else
                                                <span class="badge bg-success mb-1">Tepat Waktu</span>
                                            @endif
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">Masuk: {{ $jamMasuk }}</small>
                                            <small class="text-secondary d-block" style="font-size: 0.65rem;">Batas: {{ $currentBatas }} WIB</small>
                                        </div>
                                    @else
                                        <div class="bg-warning bg-opacity-10 text-warning p-2.5 rounded-3 fs-4">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        </div>
                                        <div>
                                            <span class="text-muted small d-block" style="font-size: 0.75rem;">Status Hari Ini</span>
                                            <span class="badge bg-warning text-dark mb-1">Belum Absen</span>
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">Batas jam {{ $currentBatas }} WIB</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card Utama Scanner -->
                        <div class="dashboard-card shadow-sm mb-4">
                            <div class="text-center mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3 shadow-sm" style="width: 60px; height: 60px;">
                                    <i class="fa-solid fa-qrcode fs-3"></i>
                                </div>
                                <h4 class="fw-bold text-dark">Scan QR Absensi</h4>
                                <p class="text-muted small mb-0">Arahkan kamera perangkat Anda atau upload gambar QR Code resmi dari Admin SAMSAT KBB.</p>
                            </div>

                            <!-- Area Kamera / Scanner -->
                            <div class="text-center p-3 border border-2 border-dashed rounded-4 bg-light mb-3">
                                <div id="reader"></div>

                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <button type="button" id="btn-scanner" class="btn btn-primary btn-sm px-4 rounded-pill shadow-sm" onclick="toggleScanner()">
                                        <i class="fa-solid fa-play me-1"></i> Start Scanning
                                    </button>
                                    <label class="btn btn-outline-secondary btn-sm px-3 rounded-pill mb-0" style="cursor: pointer;">
                                        <i class="fa-solid fa-image me-1"></i> Scan dari Gambar
                                        <input type="file" id="qr-input-file" accept="image/*" style="display: none;">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Card Riwayat Presensi Peserta dengan Toggle & Filter Single Tanggal -->
                        <div class="dashboard-card shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Cek Riwayat Presensi</h5>
                                <!-- Tombol otomatis menyesuaikan teks dan status terbuka jika tanggal dipilih -->
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRiwayat" aria-expanded="{{ isset($tanggalPilih) ? 'true' : 'false' }}" aria-controls="collapseRiwayat">
                                    <i class="fa-solid fa-calendar-days me-1"></i> {{ isset($tanggalPilih) ? 'Cek Riwayat Presensi' : 'Pilih Tanggal Riwayat' }}
                                </button>
                            </div>
                            <p class="text-muted small mb-0">Klik tombol di atas untuk memilih tanggal spesifik dan melihat status kehadiran Anda.</p>

                            <!-- Bagian Collapse (Otomatis 'show' jika tanggal sudah dipilih agar tidak tertutup sendiri) -->
                            <div class="collapse mt-3 {{ isset($tanggalPilih) ? 'show' : '' }}" id="collapseRiwayat">
                                <div class="card card-body bg-light border-0 rounded-4 p-3 mb-3">
                                    <form action="{{ route('magang.scan') }}" method="GET" class="row g-3 align-items-end">
                                        <div class="col-md-9">
                                            <label class="form-label small fw-semibold text-dark">Pilih Tanggal Kehadiran:</label>
                                            <input type="date" name="tanggal_pilih" class="form-control form-control-sm" value="{{ $tanggalPilih ?? '' }}" required>
                                        </div>
                                        <div class="col-md-3 d-grid">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-magnifying-glass me-1"></i> Lihat Data</button>
                                        </div>
                                    </form>
                                </div>

                                @if(isset($tanggalPilih))
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="py-3 text-center" width="5%">No</th>
                                                    <th class="py-3">Tanggal & Hari</th>
                                                    <th class="py-3 text-center">Jam Masuk</th>
                                                    <th class="py-3 text-center">Status Kehadiran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($riwayatAbsen as $index =>$absen)
                                                    @php
                                                        $carbonDate = \Carbon\Carbon::parse($absen->tanggal);
                                                        $namaHari =$carbonDate->locale('id')->isoFormat('dddd');
                                                        $formattedDate =$carbonDate->locale('id')->isoFormat('D MMMM Y');
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                                                        <td>
                                                            <span class="fw-semibold text-dark d-block">{{ $namaHari }}, {{$formattedDate }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($absen->jam_masuk)
                                                                <span class="badge bg-light text-dark border px-2 py-1"><i class="fa-regular fa-clock me-1 text-muted"></i> {{ $absen->jam_masuk }}</span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($absen->status == 'Hadir')
                                                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill fw-semibold">Hadir (Tepat Waktu)</span>
                                                            @elseif($absen->status == 'Terlambat')
                                                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1.5 rounded-pill fw-semibold">Terlambat</span>
                                                            @elseif($absen->status == 'Izin')
                                                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-1.5 rounded-pill fw-semibold">Izin</span>
                                                            @elseif($absen->status == 'Sakit')
                                                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1.5 rounded-pill fw-semibold">Sakit</span>
                                                            @else
                                                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1.5 rounded-pill fw-semibold">Alpha / Tidak Hadir</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-4 text-muted">
                                                            <i class="fa-solid fa-folder-open fs-3 d-block mb-2 text-secondary opacity-50"></i>
                                                            Tidak ada data presensi pada tanggal tersebut.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Form Tersembunyi untuk Scan -->
    <form id="form-scan" action="{{ route('magang.storeScan') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="token_qr" id="token_qr_input">
        <input type="hidden" name="latitude" id="latitude_input">
        <input type="hidden" name="longitude" id="longitude_input">
    </form>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/scanner-magang.js') }}"></script>

    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('live-clock').innerText = `${hours}:${minutes}:${seconds}`;

            const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };
            document.getElementById('live-date').innerText = now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>

    @if(session('success_login'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: "{{ session('success_login') }}", showConfirmButton: false, timer: 3000, timerProgressBar: true });
        });
    </script>
    @endif

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({ icon: 'success', title: 'Absensi Berhasil! 🎉', text: "{{ session('success') }}", confirmButtonColor: '#198754', timer: 2500, timerProgressBar: true });
        });
    </script>
    @endif

    @if(session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({ icon: 'warning', title: 'Perhatian', text: "{{ session('warning') }}", confirmButtonColor: '#ffc107' });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}", confirmButtonColor: '#dc3545' });
        });
    </script>
    @endif
</body>
</html>