<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginPenyewaController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('penyewa.login.index');
    }

    // Memproses data login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek login dan pastikan role-nya adalah 'penyewa'
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->role === 'penyewa') {
                $request->session()->regenerate();
                // Arahkan ke dashboard khusus penyewa nanti
                return redirect()->intended('/penyewa/dashboard');
            }

            // Jika bukan penyewa, logout otomatis
            Auth::logout();
            return back()->with('error', 'Akses ditolak. Akun ini bukan akun Penyewa.');
        }

        return back()->with('error', 'Email atau Password salah.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('penyewa.login');
    }
}