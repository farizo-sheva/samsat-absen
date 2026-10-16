<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesertaMagangController;

// Rute Landing Page Peserta Magang
Route::get('/magang', function () {
    return view('magang.landing');
})->name('magang.landing');

// Rute Pendaftaran (Register)
Route::get('/magang/register', [PesertaMagangController::class, 'showRegister'])->name('magang.register');
Route::post('/magang/register', [PesertaMagangController::class, 'storeRegister'])->name('magang.register.store');

// Rute Login & Logout
Route::get('/magang/login', [PesertaMagangController::class, 'showLogin'])->name('magang.login');
Route::post('/magang/login', [PesertaMagangController::class, 'login'])->name('magang.login.submit');
Route::post('/magang/logout', [PesertaMagangController::class, 'logout'])->name('magang.logout');

// Rute Scan Absensi (Hanya bisa diakses setelah login)
Route::get('/magang/scan', [PesertaMagangController::class, 'showScan'])->name('magang.scan');
Route::post('/magang/scan', [PesertaMagangController::class, 'storeScan'])->name('magang.storeScan');