<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterPenyewaController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input registrasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // Generate UUID untuk relasi pelanggan
            $newUuid = (string) Str::uuid();

            // Simpan data ke tabel pelanggans
            DB::table('pelanggans')->insert([
                'id' => $newUuid, 
                'nama' => $request->name,
                'kontak' => '-',
                'alamat' => '-',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Buat akun login di tabel users
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'penyewa',
                'pelanggan_id' => $newUuid,
            ]);

            DB::commit();

            // Redirect ke halaman login jika berhasil
            return redirect()->route('penyewa.login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');

        } catch (\Exception $e) {
            DB::rollback();

            // Kembali ke form jika terjadi error
            return back()->with('error', 'Pendaftaran Gagal: ' . $e->getMessage());
        }
    }
}