// public/js/scanner-magang.js

let html5QrCode;
let isScanning = false;

// Load SweetAlert2 otomatis jika belum ada di halaman
if (typeof Swal === 'undefined') {
    let script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    document.head.appendChild(script);
}

function toggleScanner() {
    const btn = document.getElementById('btn-scanner');

    if (!isScanning) {
        btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin me-1"></i> Memuat Kamera...`;
        btn.disabled = true;

        html5QrCode = new Html5Qrcode("reader");
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

        html5QrCode.start(
            { facingMode: "environment" }, 
            config,
            (decodedText, decodedResult) => {
                handleQRCodeScanned(decodedText);
            },
            (errorMessage) => {}
        ).then(() => {
            isScanning = true;
            btn.innerHTML = `<i class="fa-solid fa-stop me-1"></i> Stop Scanning`;
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-danger');
            btn.disabled = false;
        }).catch((err) => {
            Swal.fire({ icon: 'error', title: 'Gagal Membuka Kamera', text: err });
            btn.innerHTML = `<i class="fa-solid fa-play me-1"></i> Start Scanning`;
            btn.disabled = false;
        });
    } else {
        stopScanner();
    }
}

function stopScanner() {
    if (html5QrCode && isScanning) {
        html5QrCode.stop().then(() => {
            isScanning = false;
            resetButtonUI();
        }).catch(() => { isScanning = false; resetButtonUI(); });
    } else {
        isScanning = false;
        resetButtonUI();
    }
}

function resetButtonUI() {
    const btn = document.getElementById('btn-scanner');
    if(btn) {
        btn.innerHTML = `<i class="fa-solid fa-play me-1"></i> Start Scanning`;
        btn.classList.remove('btn-danger');
        btn.classList.add('btn-primary');
        btn.disabled = false;
    }
}

function handleQRCodeScanned(qrCodeText) {
    if (isScanning) {
        html5QrCode.stop().then(() => {
            isScanning = false;
            submitAbsenForm(qrCodeText);
        }).catch(() => {
            submitAbsenForm(qrCodeText);
        });
    } else {
        submitAbsenForm(qrCodeText);
    }
}

// Fungsi mengirim data secara otomatis lewat form tersembunyi ke Laravel (Dilengkapi Validasi GPS)
function submitAbsenForm(code) {
    Swal.fire({
        title: 'Mendeteksi Lokasi GPS...',
        text: 'Mohon tunggu sebentar, sedang mencocokkan koordinat Anda dengan area SAMSAT KBB.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    // Ambil koordinat GPS perangkat peserta terlebih dahulu
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Buat form dinamis untuk POST ke route absen
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/magang/scan'; // Sesuaikan route endpoint absen anda

                // CSRF Token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfInput);

                // QR Code Input (Sesuaikan name dengan controller: token_qr atau qr_code)
                const qrInput = document.createElement('input');
                qrInput.type = 'hidden';
                qrInput.name = 'token_qr';
                qrInput.value = code;
                form.appendChild(qrInput);

                // Latitude Input
                const latInput = document.createElement('input');
                latInput.type = 'hidden';
                latInput.name = 'latitude';
                latInput.value = latitude;
                form.appendChild(latInput);

                // Longitude Input
                const lonInput = document.createElement('input');
                lonInput.type = 'hidden';
                lonInput.name = 'longitude';
                lonInput.value = longitude;
                form.appendChild(lonInput);

                document.body.appendChild(form);
                form.submit();
            },
            function (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'GPS Tidak Aktif / Ditolak',
                    text: 'Gagal mendeteksi lokasi Anda. Harap aktifkan izin lokasi (GPS) pada pengaturan browser atau perangkat Anda!',
                    confirmButtonColor: '#dc3545'
                });
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Tidak Didukung',
            text: 'Browser Anda tidak mendukung fitur Geolocation (GPS).',
            confirmButtonColor: '#dc3545'
        });
    }
}

// Event listener untuk Upload File Gambar
document.addEventListener('DOMContentLoaded', function() {
    const fileinput = document.getElementById('qr-input-file');
    if (fileinput) {
        fileinput.addEventListener('change', e => {
            if (e.target.files.length == 0) return;
            
            if (isScanning) {
                if (html5QrCode) { html5QrCode.stop().catch(() => {}); }
                isScanning = false;
                resetButtonUI();
            }

            const imageFile = e.target.files[0];
            
            Swal.fire({
                title: 'Membaca QR Code...',
                text: 'Menganalisis gambar...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            const html5QrCodeForFile = new Html5Qrcode("reader");
            
            html5QrCodeForFile.scanFile(imageFile, true)
            .then(decodedText => {
                Swal.close();
                handleQRCodeScanned(decodedText);
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Membaca Gambar',
                    text: 'Pastikan gambar QR Code jelas dan valid.',
                    confirmButtonColor: '#dc3545'
                });
            });
        });
    }
});