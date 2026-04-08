<?php

namespace App\Http\Controllers;

use App\Models\PricingAlat;
use App\Models\AlatBerat;
use Illuminate\Http\Request;

class PricingAlatController extends Controller
{
    /**
     * Menampilkan daftar pricing alat berat.
     */
    public function index()
    {
        $data = PricingAlat::with('alat')
            ->orderBy('berlaku_mulai', 'desc')
            ->get();

        // UBAH: Diarahkan ke folder admin.pricing
        return view('admin.pricing.index', compact('data'));
    }

    /**
     * Menampilkan form tambah pricing.
     */
    public function create()
    {
        $alat = AlatBerat::orderBy('nama_alat')->get();
        // UBAH: Diarahkan ke folder admin.pricing
        return view('admin.pricing.create', compact('alat'));
    }

    /**
     * Menyimpan pricing baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alat_berat_id'    => 'required|exists:alat_berats,id',
            'jenis_pekerjaan'  => 'required|in:baket,breker',
            'harga_per_hari'   => 'nullable|integer',
            'harga_per_jam'    => 'nullable|integer',
            'berlaku_mulai'    => 'required|date',
            'berlaku_selesai'  => 'nullable|date|after_or_equal:berlaku_mulai',
            'status'           => 'required|in:ready,in_use,maintenance',
        ]);

        PricingAlat::create($validated);

        return redirect()->route('pricing.index')
            ->with('success', 'Pricing alat berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pricing.
     */
    public function edit($id)
    {
        $data = PricingAlat::findOrFail($id);
        $alat = AlatBerat::orderBy('nama_alat')->get();

        // UBAH: Diarahkan ke folder admin.pricing
        return view('admin.pricing.edit', compact('data', 'alat'));
    }

    /**
     * Memperbarui data pricing.
     */
    public function update(Request $request, $id)
    {
        $pricing = PricingAlat::findOrFail($id);

        $validated = $request->validate([
            'alat_berat_id'    => 'required|exists:alat_berats,id',
            'jenis_pekerjaan'  => 'required|in:baket,breker',
            'harga_per_hari'   => 'nullable|integer',
            'harga_per_jam'    => 'nullable|integer',
            'berlaku_mulai'    => 'required|date',
            'berlaku_selesai'  => 'nullable|date|after_or_equal:berlaku_mulai',
            'status'           => 'required|in:ready,in_use,maintenance',
        ]);

        $pricing->update($validated);

        return redirect()->route('pricing.index')
            ->with('success', 'Pricing alat berhasil diperbarui.');
    }

    /**
     * Menghapus data pricing.
     */
    public function destroy($id)
    {
        $pricing = PricingAlat::findOrFail($id);
        $pricing->delete();

        return redirect()->route('pricing.index')
            ->with('success', 'Pricing alat berhasil dihapus.');
    }
}