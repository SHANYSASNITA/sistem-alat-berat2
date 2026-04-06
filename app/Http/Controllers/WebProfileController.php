<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WebProfileController extends Controller
{
    // Menampilkan semua form dalam satu halaman
    public function index()
    {
        $profile = DB::table('web_profiles')->first();
        return view('admin.web_profile.index', compact('profile'));
    }

 public function update(Request $request)
    {
        // 1. Ambil semua input kecuali token dan file
        $data = $request->except(['_token', 'about_image', 'hero_image']);
        $data['updated_at'] = now();

        // 2. Logika Upload Foto Hero
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            
            // JURUS ANTI GAGAL 1: Hilangkan spasi pada nama file asli
            $nama_asli = str_replace(' ', '_', $file->getClientOriginalName());
            $nama_file = time() . "_hero_" . $nama_asli;
            
            // JURUS ANTI GAGAL 2: Gunakan parameter ke-3 ('public') untuk memaksa masuk ke storage/app/public
            $file->storeAs('profile', $nama_file, 'public');
            
            $data['hero_image'] = 'profile/' . $nama_file;
        }

        // 3. Logika Upload Foto About
        if ($request->hasFile('about_image')) {
            $file = $request->file('about_image');
            
            // Bersihkan spasi juga
            $nama_asli = str_replace(' ', '_', $file->getClientOriginalName());
            $nama_file = time() . "_about_" . $nama_asli;
            
            // Paksa masuk ke disk public
            $file->storeAs('profile', $nama_file, 'public');
            
            $data['about_image'] = 'profile/' . $nama_file;
        }

        // 4. Eksekusi ke Database
        DB::table('web_profiles')->updateOrInsert(['id' => 1], $data);

        return redirect()->back()->with('success', 'Konten Landing Page berhasil diperbarui!');
    }
}