<?php

namespace App\Http\Controllers;

use App\Models\LokasiProyek;
use Illuminate\Http\Request;

class LokasiProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = LokasiProyek::orderBy('nama_lokasi')->get();
        // UBAH: diarahkan ke folder admin.lokasi_proyek
        return view('admin.lokasi_proyek.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // UBAH: diarahkan ke folder admin.lokasi_proyek
        return view('admin.lokasi_proyek.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'kabupaten'   => 'nullable|string|max:255',
            'alamat'      => 'nullable|string',
        ]);

        LokasiProyek::create($validated);

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi proyek berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = LokasiProyek::findOrFail($id);
        // UBAH: diarahkan ke folder admin.lokasi_proyek
        return view('admin.lokasi_proyek.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lokasi = LokasiProyek::findOrFail($id);

        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'kabupaten'   => 'nullable|string|max:255',
            'alamat'      => 'nullable|string',
        ]);

        $lokasi->update($validated);

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi proyek berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lokasi = LokasiProyek::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi proyek berhasil dihapus.');
    }
}