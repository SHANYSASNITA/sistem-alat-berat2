<?php

namespace App\Http\Controllers;

use App\Models\AlatBerat; 
use App\Models\Operator;
use App\Models\Pelanggan;
use App\Models\TransaksiSewa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAlat = AlatBerat::count();
        $totalOperator = Operator::count();
        $totalPelanggan = Pelanggan::count();
        $proyekAktif = TransaksiSewa::where('status', '!=', 'selesai')->count();

        return view('admin.dashboard.dashboard', compact(
            'totalAlat', 
            'totalOperator', 
            'totalPelanggan', 
            'proyekAktif'
        ));
    }
}