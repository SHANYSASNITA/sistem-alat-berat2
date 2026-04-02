<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAdmin extends Controller
{
    /**
     * Menampilkan halaman login khusus admin.
     */
    public function index()
    {
        // Pastikan file view ini ada di resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Menangani proses autentikasi admin.
     */
    public function authenticate(Request $request)
    {
        // Validasi input untuk menjamin integritas data
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Mencoba login dengan credentials yang diberikan
        if (Auth::attempt($credentials)) {
            // Mencegah serangan Session Fixation
            $request->session()->regenerate();

            // Redirect ke dashboard manajemen alat berat
            return redirect()->intended('admin/alat');
        }

        // Jika gagal, kembali dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Menangani proses keluar (logout).
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembali ke landing page CV Lisan setelah logout
        return redirect('/login');
    }
}