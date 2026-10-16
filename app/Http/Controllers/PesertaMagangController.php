<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaMagang;
use App\Models\Absen;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PesertaMagangController extends Controller
{
    public function showRegister()
    {
        return view('magang.register');
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'asal_instansi' => 'required|string|max:255',
            'email' => 'required|email|unique:peserta_magang,email',
            'password' => 'required|min:6',
        ]);

        PesertaMagang::create([
            'nama' => $request->nama,
            'asal_instansi' => $request->asal_instansi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('magang.login')->with('success_login', 'Registrasi berhasil! Silakan login untuk melakukan absensi.');
    }

    public function showLogin()
    {
        return view('magang.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $peserta = PesertaMagang::where('email', $request->email)
                            ->orWhere('nama', $request->email)
                            ->first();

        if ($peserta && Hash::check($request->password, $peserta->password)) {
            session([
                'magang_id' => $peserta->id,
                'magang_nama' => $peserta->nama
            ]);
            
            return redirect()->route('magang.scan')->with('success_login', 'Berhasil masuk, silahkan absensi.');
        }

        return redirect()->to('/magang/login?error=Email atau password salah!');
    }

    // 5. Menampilkan Halaman Scan & Riwayat Berdasarkan 1 Tanggal Pilihan
    public function showScan(Request $request)
    {
        if (!session()->has('magang_id')) {
            return redirect()->route('magang.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $pesertaId = session('magang_id');
        $peserta = PesertaMagang::find($pesertaId);
        $tanggalHariIni = Carbon::now()->format('Y-m-d');

        // Cek status absen hari ini
        $absenHariIni = Absen::where('peserta_magang_id', $pesertaId)
                           ->where('tanggal', $tanggalHariIni)
                           ->first();

        // Ambil input tanggal tunggal yang dipilih user (default kosong atau hari ini)
        $tanggalPilih = $request->input('tanggal_pilih');

        $riwayatAbsen = [];

        if ($tanggalPilih) {
            // Cek apakah ada data absen pada tanggal tersebut di database
            $absenData = Absen::where('peserta_magang_id', $pesertaId)
                              ->where('tanggal', $tanggalPilih)
                              ->first();

            if ($absenData) {
                $riwayatAbsen[] = $absenData;
            } else {
                // Jika tanggal yang dipilih di masa lalu dan belum ada data, tampilkan sebagai Alpha / Tidak Hadir
                if (Carbon::parse($tanggalPilih)->lte(Carbon::now())) {
                    $dummyAbsen = new Absen([
                        'tanggal' => $tanggalPilih,
                        'jam_masuk' => null,
                        'status' => ($tanggalPilih == $tanggalHariIni) ? 'Belum Absen' : 'Alpha'
                    ]);
                    $riwayatAbsen[] = $dummyAbsen;
                }
            }
        }

        return view('magang.scan', compact('peserta', 'absenHariIni', 'riwayatAbsen', 'tanggalPilih'));
    }

    public function storeScan(Request $request)
    {
        if (!session()->has('magang_id')) {
            return redirect()->route('magang.login')->with('error', 'Sesi habis, silakan login kembali.');
        }

        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ], [
            'latitude.required' => 'Gagal mendeteksi lokasi GPS.',
            'longitude.required' => 'Gagal mendeteksi lokasi GPS.',
        ]);

        $pesertaId = session('magang_id');
        $peserta = PesertaMagang::find($pesertaId);
        $tanggalHariIni = Carbon::now()->format('Y-m-d');

        $sudahAbsen = Absen::where('peserta_magang_id', $peserta->id)
                           ->where('tanggal', $tanggalHariIni)
                           ->first();

        if ($sudahAbsen) {
            return back()->with('warning', 'Halo ' . $peserta->nama . ', Anda sudah melakukan absensi hari ini!');
        }

        $latUser = $request->latitude;
        $lonUser = $request->longitude;

        $officeLat = DB::table('settings')->where('key_name', 'office_latitude')->value('key_value') ?? '-6.864185';
        $officeLon = DB::table('settings')->where('key_name', 'office_longitude')->value('key_value') ?? '107.506845';
        $maxRadius = DB::table('settings')->where('key_name', 'radius_tolerance')->value('key_value') ?? 150;

        $earthRadius = 6371000;
        $dLat = deg2rad($latUser - $officeLat);
        $dLon = deg2rad($lonUser - $officeLon);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($officeLat)) * cos(deg2rad($latUser)) *
             sin($dLon / 2) * sin($dLon / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        if ($distance > $maxRadius) {
            return back()->with('error', 'Absensi ditolak! Anda berada di luar area Kantor SAMSAT KBB.');
        }

        $batasJamMasuk = DB::table('settings')->where('key_name', 'batas_jam_masuk')->value('key_value') ?? '08:00';
        $jamSekarang = Carbon::now();
        
        $batasWaktuCarbon = Carbon::createFromTimeString($batasJamMasuk . ':00');
        $status = $jamSekarang->greaterThan($batasWaktuCarbon) ? 'Terlambat' : 'Hadir';

        Absen::create([
            'peserta_magang_id' => $peserta->id,
            'tanggal' => $tanggalHariIni,
            'jam_masuk' => $jamSekarang->format('H:i:s'),
            'status' => $status,
        ]);

        return back()->with('success', 'Absensi Berhasil tercatat! Lokasi Anda berada di dalam area SAMSAT KBB.');
    }

    public function logout()
    {
        session()->forget(['magang_id', 'magang_nama']);
        return redirect()->route('magang.login')->with('success_login', 'Berhasil keluar.');
    }
}