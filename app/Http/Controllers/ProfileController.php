<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil
     */
    public function index()
    {
        $user = Auth::user(); // Ambil data user yang sedang login
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Memperbarui Informasi Profil (Nama & Email)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            // Validasi email: wajib unik, KECUALI untuk email dia sendiri
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Informasi profil berhasil diperbarui!');
    }

    /**
     * Memperbarui Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password', // Mengecek password lama
            'password'         => 'required|string|min:8|confirmed', // Harus cocok dengan password_confirmation
        ], [
            'current_password.current_password' => 'Password lama yang Anda masukkan salah.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password minimal harus 8 karakter.'
        ]);

        // Jika lolos validasi, ganti dengan password baru yang di-hash
        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}