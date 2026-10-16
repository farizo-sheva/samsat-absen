/**
 * Dashboard Admin - SAMSAT KBB Portal Magang
 * Script untuk interaksi admin (Auto-close alert, SweetAlert Confirmation, & Live Search)
 */

document.addEventListener('DOMContentLoaded', function () {
    
    // 1. Auto close alert sukses setelah 4 detik
    const alertElement = document.querySelector('.alert');
    if (alertElement) {
        setTimeout(function () {
            let alertInstance = new bootstrap.Alert(alertElement);
            alertInstance.close();
        }, 4000);
    }

    // 2. Konfirmasi SweetAlert saat mengubah status kehadiran manual
    const statusForms = document.querySelectorAll('.status-form');
    statusForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Cegah submit langsung

            const button = e.submitter; // Tombol mana yang diklik (Hadir / Izin / Sakit)
            const statusTarget = button ? button.value : 'Status Baru';
            const namaPeserta = form.getAttribute('data-nama');

            // Tentukan warna tema berdasarkan status
            let confirmColor = '#0d6efd';
            if (statusTarget === 'Hadir') confirmColor = '#198754';
            else if (statusTarget === 'Izin') confirmColor = '#ffc107';
            else if (statusTarget === 'Sakit') confirmColor = '#dc3545';

            Swal.fire({
                title: 'Konfirmasi Ubah Status',
                text: `Ubah status kehadiran "${namaPeserta}" menjadi ${statusTarget}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: confirmColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Ya, Set ${statusTarget}!`,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat hidden input untuk membawa nilai tombol yang diklik karena e.submitter hilang saat submit manual
                    let hiddenStatus = document.createElement('input');
                    hiddenStatus.type = 'hidden';
                    hiddenStatus.name = 'status';
                    hiddenStatus.value = statusTarget;
                    form.appendChild(hiddenStatus);

                    form.submit(); // Lanjutkan submit form
                }
            });
        });
    });

    // 3. Fitur Pencarian Instan (Live Search) pada Tabel Peserta
    const searchInput = document.getElementById('searchPeserta');
    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            let keyword = searchInput.value.toLowerCase();
            let tableRows = document.querySelectorAll('#tabelPeserta tr');

            tableRows.forEach(row => {
                let namaText = row.getAttribute('data-nama') || '';
                let instansiText = row.getAttribute('data-instansi') || '';

                if (namaText.includes(keyword) || instansiText.includes(keyword)) {
                    row.style.display = ''; // Tampilkan baris
                } else {
                    row.style.display = 'none'; // Sembunyikan baris
                }
            });
        });
    }

});