<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbsenController;

// Rute Landing Page Admin (Mengarah ke resources/views/admin/landing.blade.php)
Route::get('/admin/landing', function () {
    return view('admin.landing');
})->name('admin.landing');

// Rute Autentikasi Admin (Publik)
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/register', [AdminController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'storeRegister'])->name('admin.register.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Rute Dashboard & Fitur Admin (Sudah diamankan secara internal oleh pengecekan session('admin_id') di AdminController)
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/absen/update/{id}', [AbsenController::class, 'updateStatus'])->name('admin.absen.update');
Route::get('/admin/absen/export', [AbsenController::class, 'exportExcel'])->name('admin.absen.export');

// TAMBAHAN RUTE PENGATURAN JAM MASUK
Route::post('/admin/setting/update-jam', [AdminController::class, 'updateBatasJam'])->name('admin.setting.update-jam');