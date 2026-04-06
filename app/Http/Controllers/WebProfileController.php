<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;

class WebProfileController extends Controller
{
    /**
     * Helper untuk mengambil data profil tunggal
     */
    private function getProfile()
    {
        return DB::table('web_profiles')->first();
    }

    // 1. Menampilkan Form Hero Section
    public function editHero()
    {
        $profile = $this->getProfile();
        return view('admin.web_profile.hero', compact('profile'));
    }

    // 2. Menampilkan Form About Us
    public function editAbout()
    {
        $profile = $this->getProfile();
        return view('admin.web_profile.about', compact('profile'));
    }

    // 3. Menampilkan Form Services
    public function editServices()
    {
        $profile = $this->getProfile();
        return view('admin.web_profile.services', compact('profile'));
    }

    /**
     * Fungsi tunggal untuk mengupdate semua bagian
     */
    public function update(Request $request)
    {
        // Ambil semua input kecuali token dan file
        $data = $request->except(['_token', 'about_image', 'hero_image']);
        $data['updated_at'] = now();

       
       // Logika Upload Foto Hero (Jika Anda menambah kolom hero_image nanti)
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $nama_file = time() . "_hero_" . $file->getClientOriginalName();
            $file->storeAs('public/profile', $nama_file);
            $data['hero_image'] = 'profile/' . $nama_file;
        }
       
       
        // Logika Upload Foto About
        if ($request->hasFile('about_image')) {
            $file = $request->file('about_image');
            $nama_file = time() . "_about_" . $file->getClientOriginalName();
            $file->storeAs('public/profile', $nama_file);
            $data['about_image'] = 'profile/' . $nama_file;
        }
        

        // Simpan atau Update data dengan ID 1
        DB::table('web_profiles')->updateOrInsert(['id' => 1], $data);

        
        return redirect()->back()->with('success', 'Konten berhasil diperbarui!');
    }
}