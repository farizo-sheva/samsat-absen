<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Absensi Magang SAMSAT KBB</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- CSS Kustom Terpisah -->
    <link rel="stylesheet" href="{{ asset('css/dashboard-admin.css') }}">
</head>
<body>

    <!-- Navbar Atas -->
    <nav class="navbar navbar-expand-lg navbar-custom py-3 px-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="#">
                <i class="fa-solid fa-building-columns me-2"></i> SAMSAT KBB - Portal Magang
            </a>
            
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="navbar-text text-secondary small d-none d-md-inline">
                    <i class="fa-regular fa-calendar-days me-1"></i> Hari ini: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                </span>

                <!-- Dropdown Profil Admin -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle bg-light px-3 py-1.5 rounded-pill border shadow-sm" id="dropdownAdminMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                            <i class="fa-solid fa-user" style="font-size: 13px;"></i>
                        </div>
                        <span class="fw-semibold small me-1">{{ session('admin_name', 'Admin') }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 py-2" aria-labelledby="dropdownAdminMenu">
                        <li class="px-3 py-1 mb-1 border-bottom">
                            <span class="text-muted d-block" style="font-size: 11px;">Masuk sebagai:</span>
                            <strong class="text-dark small">{{ session('admin_username', 'Administrator') }}</strong>
                        </li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST" class="px-2">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger rounded-3 py-2 fw-semibold d-flex align-items-center">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container my-5">
        
        <!-- Header & Aksi -->
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h3 class="fw-bold text-dark mb-1">Rekap Absensi Harian</h3>
                <p class="text-muted mb-0">Kelola dan pantau kehadiran peserta magang.</p>
            </div>
            <div class="col-md-8 text-md-end mt-3 mt-md-0">
                <div class="d-inline-flex gap-2 align-items-center flex-wrap justify-content-md-end">
                    <button type="button" class="btn btn-outline-dark btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#settingModal">
                        <i class="fa-solid fa-gear me-1"></i> Atur Jam Masuk
                    </button>
                    <button type="button" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#qrModal">
                        <i class="fa-solid fa-qrcode me-1"></i> QR Code Absensi
                    </button>
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="d-inline-flex gap-2">
                        <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control form-control-sm">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                    </form>
                    <a href="{{ route('admin.absen.export', ['tanggal' => $tanggal]) }}" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-file-excel me-1"></i> Excel
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tabel Data -->
        <div class="card shadow-sm border-0">
            <div class="card-header card-header-custom py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                <div>
                    @php
                        $currentBatas = \DB::table('settings')->where('key_name', 'batas_jam_masuk')->value('key_value') ?? '08:00';
                    @endphp
                    <span class="fw-bold"><i class="fa-solid fa-users-line me-2"></i> Daftar Peserta Magang (Urut A - Z)</span>
                    <span class="badge bg-light text-dark ms-2">Total: {{ count($pesertaList) }} Orang</span>
                    <span class="badge bg-warning text-dark ms-1">Batas Jam Masuk: {{ $currentBatas }} WIB</span>
                </div>
                <div style="width: 250px;">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search text-muted"></i></span>
                        <input type="text" id="searchPeserta" class="form-control border-start-0 ps-0" placeholder="Cari nama / instansi...">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase fs-7">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Nama Peserta</th>
                                <th>Asal Instansi</th>
                                <th>Jam Masuk</th>
                                <th>Status Kehadiran</th>
                                <th>Keterangan Telat</th>
                                <th class="text-center pe-4">Aksi / Ubah Status Manual</th>
                            </tr>
                        </thead>
                        <tbody id="tabelPeserta">
                            @forelse($pesertaList as $index => $peserta)
                                @php
                                    $absenHariIni = $absens[$peserta->id] ?? null;
                                    $status = $absenHariIni ? $absenHariIni->status : '-';
                                    $jamMasuk = ($absenHariIni && $absenHariIni->jam_masuk) ? $absenHariIni->jam_masuk : '-';

                                    $keteranganTelat = '-';
                                    if ($jamMasuk !== '-') {
                                        $jamMasukCarbon = \Carbon\Carbon::createFromTimeString($jamMasuk);
                                        $batasWaktuCarbon = \Carbon\Carbon::createFromTimeString($currentBatas . ':00');
                                        
                                        if ($jamMasukCarbon->greaterThan($batasWaktuCarbon)) {
                                            $selisihMenit = $batasWaktuCarbon->diffInMinutes($jamMasukCarbon);
                                            $jamTelat = floor($selisihMenit / 60);
                                            $menitTelat = $selisihMenit % 60;
                                            $keteranganTelat = 'Telat ' . ($jamTelat > 0 ? "$jamTelat jam " : "") . "$menitTelat menit";
                                        } else {
                                            $keteranganTelat = 'Tepat Waktu';
                                        }
                                    }
                                @endphp
                                <tr data-nama="{{ strtolower($peserta->nama) }}" data-instansi="{{ strtolower($peserta->asal_instansi) }}">
                                    <td class="ps-4 fw-bold text-secondary">{{ $index + 1 }}</td>
                                    <td><div class="fw-bold text-dark">{{ $peserta->nama }}</div></td>
                                    <td><span class="text-muted small">{{ $peserta->asal_instansi }}</span></td>
                                    <td><code>{{ $jamMasuk !== '-' ? $jamMasuk : 'Belum Absen' }}</code></td>
                                    <td>
                                        @if($status == 'Hadir')
                                            <span class="badge bg-success px-2 py-1">Hadir</span>
                                        @elseif($status == 'Izin')
                                            <span class="badge bg-warning text-dark px-2 py-1">Izin</span>
                                        @elseif($status == 'Sakit')
                                            <span class="badge bg-danger px-2 py-1">Sakit</span>
                                        @else
                                            <span class="badge bg-secondary px-2 py-1">Belum Ada Status</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($jamMasuk !== '-')
                                            @if(str_contains($keteranganTelat, 'Telat'))
                                                <span class="text-danger fw-semibold small"><i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $keteranganTelat }}</span>
                                            @else
                                                <span class="text-success small fw-semibold"><i class="fa-solid fa-check me-1"></i> {{ $keteranganTelat }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <form action="{{ route('admin.absen.update', $peserta->id) }}" method="POST" class="status-form d-inline-flex gap-1 justify-content-center" data-nama="{{ $peserta->nama }}">
                                            @csrf
                                            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                                            <button type="submit" name="status" value="Hadir" class="btn btn-outline-success btn-sm px-2 py-0" title="Set Hadir">Hadir</button>
                                            <button type="submit" name="status" value="Izin" class="btn btn-outline-warning btn-sm px-2 py-0" title="Set Izin">Izin</button>
                                            <button type="submit" name="status" value="Sakit" class="btn btn-outline-danger btn-sm px-2 py-0" title="Set Sakit">Sakit</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data peserta magang yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PENGATURAN JAM MASUK -->
    <div class="modal fade" id="settingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <form action="{{ route('admin.setting.update-jam') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-dark text-white rounded-top-4">
                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-clock-rotate-left me-2"></i> Pengaturan Batas Jam Masuk</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <label for="batas_jam_masuk" class="form-label fw-semibold text-dark">Pilih Batas Maksimal Jam Masuk Absen:</label>
                        <input type="time" class="form-control form-control-lg fw-bold text-center" id="batas_jam_masuk" name="batas_jam_masuk" value="{{ $currentBatas }}" required>
                    </div>
                    <div class="modal-footer justify-content-between bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL QR CODE -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-qrcode me-2"></i> QR Code Absensi Hari Ini</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    @php
                        $tanggalHariIni = \Carbon\Carbon::now()->toDateString();
                        $tokenQr = 'SAMSAT-KBB-HADIR-' . $tanggalHariIni;
                        $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' . urlencode($tokenQr);
                    @endphp
                    <div class="bg-light p-3 rounded-3 d-inline-block border shadow-sm mb-3">
                        <img src="{{ $qrImageUrl }}" alt="QR Code" class="img-fluid" style="width: 200px; height: 200px;">
                    </div>
                    <input type="text" class="form-control text-center fw-bold text-dark bg-white" value="{{ $tokenQr }}" readonly>
                </div>
                <div class="modal-footer justify-content-center bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JS Eksternal Terpisah -->
    <script src="{{ asset('js/dashboard-admin.js') }}"></script>
</body>
</html>