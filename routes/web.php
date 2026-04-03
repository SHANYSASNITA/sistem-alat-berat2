<?php

use Illuminate\Support\Facades\Route;
use App\Models\AlatBerat;

// Jika Anda sudah punya Model About & Service, jangan lupa dipanggil di sini:
// use App\Models\About;
// use App\Models\Service;

// Controller sistem
use App\Http\Controllers\AlatBeratController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LokasiProyekController;
use App\Http\Controllers\PricingAlatController;
use App\Http\Controllers\TransaksiSewaController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\DpPembayaranController;
use App\Http\Controllers\HmLogController;
use App\Http\Controllers\AdminController;

// Controller autentikasi
use App\Http\Controllers\Auth\LoginAdmin;
use App\Http\Controllers\Auth\RegisterPenyewaController;
use App\Http\Controllers\Auth\LoginPenyewaController;


/*
|--------------------------------------------------------------------------
| ROUTE PENYEWA (CUSTOMER AREA)
|--------------------------------------------------------------------------
| Route untuk login, register, logout, dan dashboard penyewa
|
*/
Route::prefix('penyewa')->group(function () {

    // Halaman login penyewa
    Route::get('/login', function () {
        return view('penyewa.login.index'); 
    })->name('penyewa.login');

    // Proses login penyewa
    Route::post('/login', [LoginPenyewaController::class, 'login'])->name('penyewa.login.submit');

    // Halaman registrasi penyewa
    Route::get('/register', function () {
        return view('penyewa.register.register'); 
    })->name('penyewa.register');

    // Proses registrasi penyewa
    Route::post('/register', [RegisterPenyewaController::class, 'store'])->name('penyewa.register.store');
    
    // Logout penyewa
    Route::post('/logout', [LoginPenyewaController::class, 'logout'])->name('penyewa.logout');

    // Dashboard penyewa (harus login)
    Route::get('/dashboard', function () {
        return view('penyewa.dashboard.index');
    })->name('penyewa.dashboard')->middleware('auth');
});


/*
|--------------------------------------------------------------------------
| LANDING PAGE WEBSITE (SINGLE PAGE)
|--------------------------------------------------------------------------
| Menampilkan halaman utama website secara utuh (About, Service, Tools)
|
*/
Route::get('/', function () {
    // 1. Ambil data
    $tools = \App\Models\AlatBerat::where('status', 'active')->get(); 
    $abouts = []; // Ganti dengan pemanggilan database jika sudah siap
    $services = []; // Ganti dengan pemanggilan database jika sudah siap

    // 2. Arahkan tepat ke folder web_profile -> home -> file home.blade.php
    return view('web_profile.home.home', compact('tools', 'abouts', 'services'));
})->name('landing');
/*
|--------------------------------------------------------------------------
| AUTHENTICATION ADMIN
|--------------------------------------------------------------------------
| Login dan logout untuk admin sistem
|
*/
Route::get('/login', [LoginAdmin::class, 'index'])->name('login');
Route::post('/login', [LoginAdmin::class, 'authenticate']);
Route::post('/logout', [LoginAdmin::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ROUTE ADMIN PANEL
|--------------------------------------------------------------------------
| Semua route admin dilindungi middleware auth
|
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Manajemen master data
    Route::resource('alat', AlatBeratController::class);
    Route::resource('operator', OperatorController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('lokasi', LokasiProyekController::class);
    Route::resource('pricing', PricingAlatController::class);

    // Manajemen transaksi sewa
    Route::resource('transaksi', TransaksiSewaController::class);
    Route::resource('dp', DpPembayaranController::class);

    // Log operasional alat
    Route::resource('hm', HmLogController::class);

    // Timesheet operator
    Route::resource('timesheet', TimesheetController::class);
    
    // Export laporan timesheet
    Route::get('timesheet/{transaksi}/export', [TimesheetController::class, 'export'])
        ->name('timesheet.export');

});