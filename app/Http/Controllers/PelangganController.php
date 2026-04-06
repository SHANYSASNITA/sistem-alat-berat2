<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // WAJIB ADA: Untuk menghapus file KTP dari folder server

class PelangganController extends Controller
{
    /**
     * Menampilkan daftar pelanggan.
     */
    public function index()
    {
        $data = Pelanggan::orderBy('nama')->get();
        return view('admin.pelanggan.index', compact('data'));
    }

    /**
     * Menampilkan form tambah pelanggan.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Menyimpan data pelanggan baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'kontak'         => 'nullable|string|max:50',
            'alamat'         => 'nullable|string',
            'tanggal_lahir'  => 'required|date',
            'ktp_pelanggan'  => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // 2. Cek dan Simpan File KTP
        if ($request->hasFile('ktp_pelanggan')) {
            // Simpan ke folder storage/app/public/ktp_pelanggans
            $path = $request->file('ktp_pelanggan')->store('ktp_pelanggans', 'public');
            $validated['ktp_pelanggan'] = $path;
        }

        // 3. Simpan ke database
        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data Pelanggan beserta KTP berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pelanggan.
     */
    public function edit($id)
    {
        $data = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', compact('data'));
    }

    /**
     * Memperbarui data pelanggan.
     */
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'kontak'         => 'nullable|string|max:50',
            'alamat'         => 'nullable|string',
            'tanggal_lahir'  => 'required|date',
            'ktp_pelanggan'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Boleh kosong saat edit
        ]);

        // Jika Admin mengupload gambar KTP yang baru
        if ($request->hasFile('ktp_pelanggan')) {
            // Hapus KTP lama dari folder server (agar penyimpanan tidak penuh)
            if ($pelanggan->ktp_pelanggan && Storage::disk('public')->exists($pelanggan->ktp_pelanggan)) {
                Storage::disk('public')->delete($pelanggan->ktp_pelanggan);
            }
            
            // Simpan KTP baru
            $path = $request->file('ktp_pelanggan')->store('ktp_pelanggans', 'public');
            $validated['ktp_pelanggan'] = $path;
        }

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data Pelanggan berhasil diperbarui.');
    }

    /**
     * Menghapus data pelanggan.
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Hapus file KTP di folder server saat data pelanggan dihapus
        if ($pelanggan->ktp_pelanggan && Storage::disk('public')->exists($pelanggan->ktp_pelanggan)) {
            Storage::disk('public')->delete($pelanggan->ktp_pelanggan);
        }

        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan dan file KTP berhasil dihapus.');
    }
}