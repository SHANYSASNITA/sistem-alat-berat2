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
        return view('auth.login');
    }

    /**
     * Menangani proses autentikasi admin.
     */
    public function authenticate(Request $request)
    {
        // 1. Aturan jika kolom email dan password kosong
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email Anda tidak boleh kosong.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password Anda tidak boleh kosong.',
        ]);

        // 2. Mencoba login dengan email dan password yang diinput
        if (Auth::attempt($credentials)) {
            // Jika benar, masuk ke dashboard
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard')->with('success', 'Berhasil login! Selamat datang di Admin Panel.');
        }

        // 3. Aturan jika input email dan password salah
        return back()->withErrors([
            'login_error' => 'Email atau password salah.',
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

        return redirect('/login');
    }
}