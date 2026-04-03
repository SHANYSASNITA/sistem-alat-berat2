<?php

namespace App\Http\Controllers;

use App\Models\AlatBerat; // Sesuai folder Models Anda
use App\Models\Operator;
use App\Models\Pelanggan;
use App\Models\TransaksiSewa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Pastikan variabel di kiri ($totalAlat) sama dengan yang dipanggil di View
        $totalAlat = AlatBerat::count(); 
        $totalOperator = Operator::count();
        $totalPelanggan = Pelanggan::count();
        
        // Lokasi Proyek Aktif diambil dari TransaksiSewa
        $proyekAktif = TransaksiSewa::where('status', '!=', 'selesai')->count();

        // Variabel dalam compact() HARUS sama dengan variabel di atas (tanpa tanda $)
        return view('admin.dashboard', compact(
            'totalAlat', 
            'totalOperator', 
            'totalPelanggan', 
            'proyekAktif'
        ));
    }
}