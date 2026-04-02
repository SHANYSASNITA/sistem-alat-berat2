<?php

namespace App\Http\Controllers;

use App\Models\AlatBerat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // WAJIB DITAMBAHKAN untuk kelola file

class AlatBeratController extends Controller
{
    public function index()
    {
        $data = AlatBerat::orderBy('nama_alat')->get();
        return view('admin.alat_berat.index', compact('data')); 
    }

    public function create()
    {
        return view('admin.alat_berat.create'); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_unit' => 'required|unique:alat_berats,kode_unit',
            'nama_alat' => 'required',
            'jenis'     => 'required',
            'merk'      => 'nullable',
            'tahun'     => 'nullable|integer',
            'foto'      => 'required|image|mimes:jpeg,png,jpg|max:2048', // Di create, foto wajib
            'status'    => 'required|in:active,maintenance,broken',
        ]);

        // LOGIKA UPLOAD FOTO
        if ($request->hasFile('foto')) {
            // Simpan foto ke folder storage/app/public/alat_berat
            $path = $request->file('foto')->store('alat_berat', 'public');
            $validated['foto'] = $path; // Masukkan nama path ke array validated untuk disimpan ke DB
        }

        AlatBerat::create($validated);

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = AlatBerat::findOrFail($id);
        return view('admin.alat_berat.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $alat = AlatBerat::findOrFail($id);

        $validated = $request->validate([
            'kode_unit' => 'required|unique:alat_berats,kode_unit,' . $alat->id,
            'nama_alat' => 'required',
            'jenis'     => 'required',
            'merk'      => 'nullable',
            'tahun'     => 'nullable|integer',
            'status'    => 'required|in:active,maintenance,broken',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Di edit, foto opsional
        ]);

        // LOGIKA UPDATE FOTO
        if ($request->hasFile('foto')) {
            // 1. Hapus foto lama jika ada di dalam storage
            if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
                Storage::disk('public')->delete($alat->foto);
            }
            
            // 2. Simpan foto baru
            $path = $request->file('foto')->store('alat_berat', 'public');
            $validated['foto'] = $path;
        }

        $alat->update($validated);

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Tambahkan komentar bantuan ini di atasnya
        /** @var \App\Models\AlatBerat $alat */
        $alat = AlatBerat::findOrFail($id);
        
        // Hapus fisik file foto dari storage sebelum hapus data DB
        if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
            Storage::disk('public')->delete($alat->foto);
        }

        // Garis merah di sini akan otomatis hilang!
        $alat->delete();

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berat berhasil dihapus.');
    }
}