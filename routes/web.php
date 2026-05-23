<?php

use Illuminate\Support\Facades\Route;
use App\Models\AlatBerat;
use Illuminate\Support\Facades\DB;

// Controller sistem
use App\Http\Controllers\AlatBeratController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PricingAlatController;
use App\Http\Controllers\TransaksiSewaController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\DpPembayaranController;
use App\Http\Controllers\DashboardController;

// PERBAIKAN: Alamat WebProfileController yang benar
use App\Http\Controllers\WebProfileController; 
use App\Http\Controllers\ProfileController; 

// Controller autentikasi
use App\Http\Controllers\Auth\LoginAdmin;

/*
|--------------------------------------------------------------------------
| LANDING PAGE WEBSITE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Memanggil AlatBerat yang aktif beserta data harganya (pricing)
    $tools = AlatBerat::with('pricing')
                ->where('status', 'active')
                ->get(); 
    
    $profile = DB::table('web_profiles')->first(); 

    return view('web_profile.home.home', compact('tools', 'profile'));
})->name('landing');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginAdmin::class, 'index'])->name('login');
Route::post('/login', [LoginAdmin::class, 'authenticate']);
Route::post('/logout', [LoginAdmin::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN PANEL
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Manajemen master data
    Route::resource('alat', AlatBeratController::class);
    Route::resource('operator', OperatorController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('pricing', PricingAlatController::class);

    // ==========================================
    // ROUTE PROFIL ADMIN & GANTI PASSWORD
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    // ==========================================

    // Manajemen web profile 
    Route::prefix('web-profile')->group(function () {
        Route::get('/', [WebProfileController::class, 'index'])->name('admin.web-profile.index');
        Route::post('/update', [WebProfileController::class, 'update'])->name('admin.web-profile.update');
    });

    // Manajemen transaksi sewa
    Route::resource('transaksi', TransaksiSewaController::class);
    Route::resource('dp', DpPembayaranController::class);
    Route::resource('timesheet', TimesheetController::class);
    
    Route::get('timesheet/{transaksi}/export', [TimesheetController::class, 'export'])->name('timesheet.export');
});