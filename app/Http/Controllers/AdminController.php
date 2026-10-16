<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\PesertaMagang;
use App\Models\Absen;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. Menampilkan Form Register Admin
    public function showRegister()
    {
        return view('admin.register');
    }

    // 2. Proses Simpan Register Admin
    public function storeRegister(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username',
            'password' => 'required|min:6',
            'token_admin' => 'required',
        ]);

        $tokenRahasiaPusat = 'samsat_kbb_amanda'; 

        if ($request->token_admin !== $tokenRahasiaPusat) {
            return back()->with('error', 'Token rahasia pendaftaran admin salah!');
        }

        Admin::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', 'Akun admin berhasil dibuat! Silakan login.');
    }

    // 3. Menampilkan Form Login Admin
    public function showLogin()
    {
        return view('admin.login');
    }

    // 4. Proses Login Admin
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session([
                'admin_id' => $admin->id,
                'admin_nama' => $admin->nama,
                'admin_username' => $admin->username
            ]);
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, ' . $admin->nama);
        }

        return back()->with('error', 'Username atau password salah!');
    }

    // 5. Dashboard Admin
    public function dashboard(Request $request)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $tanggal = $request->input('tanggal', Carbon::now()->toDateString());
        $pesertaList = PesertaMagang::orderBy('nama', 'asc')->get();
        $absens = Absen::where('tanggal', $tanggal)->get()->keyBy('peserta_magang_id');

        // Ambil batas waktu dinamis dari database untuk dashboard
        $settingBatas = DB::table('settings')->where('key_name', 'batas_jam_masuk')->value('key_value') ?? '08:00';
        $batasWaktu = Carbon::createFromTimeString($settingBatas . ':00');

        foreach ($absens as $absen) {
            if ($absen->jam_masuk) {
                $jamMasukAbsen = Carbon::createFromTimeString($absen->jam_masuk);
                if ($jamMasukAbsen->greaterThan($batasWaktu)) {
                    $selisihMenit = $batasWaktu->diffInMinutes($jamMasukAbsen);
                    $jamTelat = floor($selisihMenit / 60);
                    $menitTelat = $selisihMenit % 60;
                    $absen->keterangan_telat = ($jamTelat > 0 ? "$jamTelat jam " : "") . "$menitTelat menit";
                } else {
                    $absen->keterangan_telat = null;
                }
            } else {
                $absen->keterangan_telat = null;
            }
        }

        return view('admin.dashboard', compact('pesertaList', 'absens', 'tanggal'));
    }

    // 6. Fungsi Update Batas Jam Masuk dari Dashboard Admin
    public function updateBatasJam(Request $request)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Sesi habis.');
        }

        $request->validate([
            'batas_jam_masuk' => 'required'
        ]);

        DB::table('settings')->updateOrInsert(
            ['key_name' => 'batas_jam_masuk'],
            [
                'key_value' => $request->batas_jam_masuk,
                'updated_at' => now()
            ]
        );

        return redirect()->back()->with('success', 'Batas jam masuk berhasil diperbarui!');
    }

    // 7. Logout Admin
    public function logout()
    {
        session()->forget(['admin_id', 'admin_nama', 'admin_username']);
        return redirect()->route('admin.login')->with('success', 'Berhasil keluar dari sesi admin.');
    }
}