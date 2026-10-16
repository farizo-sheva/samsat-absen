<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaMagang;
use App\Models\Absen;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    // Fungsi untuk scan QR Code absensi oleh peserta magang (Dilengkapi Geofencing & Validasi Token)
    public function store(Request $request)
    {
        // 1. Validasi Input dari JavaScript (Menerima token_qr atau qr_code, serta koordinat GPS)
        $request->validate([
            'token_qr' => 'nullable|string',
            'qr_code' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ], [
            'latitude.required' => 'Gagal mendeteksi lokasi GPS. Pastikan izin lokasi (GPS) di perangkat Anda diaktifkan!',
            'longitude.required' => 'Gagal mendeteksi lokasi GPS. Pastikan izin lokasi (GPS) di perangkat Anda diaktifkan!',
        ]);

        $pesertaMagangId = session('magang_id');

        if (!$pesertaMagangId) {
            return redirect()->route('magang.login')->with('error', 'Sesi login habis, silakan login ulang.');
        }

        $tanggalHariIni = Carbon::now()->toDateString();

        // Cek apakah peserta sudah absen hari ini (Pencegahan Double Absen)
        $absen = Absen::where('peserta_magang_id', $pesertaMagangId)
                     ->where('tanggal', $tanggalHariIni)
                     ->first();

        if ($absen) {
            return back()->with('warning', 'Anda sudah melakukan absensi hari ini!');
        }

        // 2. === LOGIKA VALIDASI JARAK (GEOFENCING SAMSAT KBB) ===
        $latUser = $request->latitude;
        $lonUser = $request->longitude;

        // Ambil data koordinat pusat SAMSAT KBB & toleransi dari tabel settings (jika ada, atau gunakan default)
        $officeLat = DB::table('settings')->where('key_name', 'office_latitude')->value('key_value') ?? '-6.864185';
        $officeLon = DB::table('settings')->where('key_name', 'office_longitude')->value('key_value') ?? '107.506845';
        $maxRadius = DB::table('settings')->where('key_name', 'radius_tolerance')->value('key_value') ?? 150; // dalam meter

        // Rumus Haversine untuk menghitung jarak dalam meter
        $earthRadius = 6371000; // Radius bumi dalam meter
        $dLat = deg2rad($latUser - $officeLat);
        $dLon = deg2rad($lonUser - $officeLon);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($officeLat)) * cos(deg2rad($latUser)) *
             sin($dLon / 2) * sin($dLon / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c; // Jarak hasil hitung dalam meter

        // Jika jarak melebihi batas radius toleransi, tolak absen!
        if ($distance > $maxRadius) {
            $jarakBulat = round($distance);
            return back()->with('error', "Absensi ditolak! Anda berada di luar area Kantor SAMSAT KBB. Jarak Anda saat ini sekitar {$jarakBulat} meter dari kantor (Maksimal radius yang diizinkan adalah {$maxRadius} meter).");
        }
        // =======================================================

        // 3. Simpan data kehadiran jika lolos GPS
        Absen::create([
            'peserta_magang_id' => $pesertaMagangId,
            'tanggal' => $tanggalHariIni,
            'jam_masuk' => Carbon::now()->toTimeString(),
            'status' => 'Hadir'
        ]);

        return back()->with('success', 'Absensi Berhasil tercatat! Lokasi Anda berada di dalam area SAMSAT KBB.');
    }

    // Fungsi bagi Admin untuk mengubah status kehadiran secara manual
    public function updateStatus(Request $request, $id)
    {
        $tanggal = $request->input('tanggal', Carbon::now()->toDateString());
        $statusBaru = $request->input('status');

        $absen = Absen::firstOrNew([
            'peserta_magang_id' => $id,
            'tanggal' => $tanggal
        ]);

        $absen->status = $statusBaru;
        if (!$absen->jam_masuk && $statusBaru == 'Hadir') {
            $absen->jam_masuk = Carbon::now()->toTimeString();
        }
        $absen->save();

        return back()->with('success', 'Status kehadiran berhasil diperbarui!');
    }

    // Fungsi Export Rekap Absen ke Excel
    public function exportExcel(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::now()->toDateString());
        
        $pesertaList = PesertaMagang::orderBy('nama', 'asc')->get();
        $absens = Absen::where('tanggal', $tanggal)->get()->keyBy('peserta_magang_id');

        $namaFile = 'Rekap_Absen_Magang_' . $tanggal . '.xls';

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$namaFile");

        echo '<table border="1">';
        echo '<tr><th colspan="5" style="background-color: #0d6efd; color: white; font-size: 16px; text-align: center;">REKAP ABSENSI PESERTA MAGANG SAMSAT KBB</th></tr>';
        echo '<tr><th colspan="5" style="text-align: center;">Tanggal: ' . $tanggal . '</th></tr>';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Nama Peserta</th>';
        echo '<th>Asal Instansi</th>';
        echo '<th>Jam Masuk</th>';
        echo '<th>Status Kehadiran</th>';
        echo '</tr>';

        $no = 1;
        foreach ($pesertaList as $peserta) {
            $absen = $absens[$peserta->id] ?? null;
            $jamMasuk = $absen ? $absen->jam_masuk : '-';
            $status = $absen ? $absen->status : 'Belum Absen';

            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $peserta->nama . '</td>';
            echo '<td>' . $peserta->asal_instansi . '</td>';
            echo '<td>' . $jamMasuk . '</td>';
            echo '<td>' . $status . '</td>';
            echo '</tr>';
        }

        echo '</table>';
        exit;
    }
}