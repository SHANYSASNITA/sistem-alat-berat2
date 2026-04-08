<?php

namespace App\Http\Controllers;

use App\Models\PricingAlat;
use App\Models\AlatBerat;
use Illuminate\Http\Request;

class PricingAlatController extends Controller
{
    public function index()
    {
        $data = PricingAlat::with('alat')
            ->orderBy('berlaku_mulai', 'desc')
            ->get();

        return view('admin.pricing.index', compact('data'));
    }

    public function create()
    {
        $alat = AlatBerat::orderBy('nama_alat')->get();
        return view('admin.pricing.create', compact('alat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alat_berat_id'   => 'required|exists:alat_berats,id',
            'layanan_baket'   => 'nullable',
            'harga_baket'     => 'nullable|integer|required_with:layanan_baket',
            'layanan_breker'  => 'nullable',
            'harga_breker'    => 'nullable|integer|required_with:layanan_breker',
            'berlaku_mulai'   => 'required|date',
            'berlaku_selesai' => 'nullable|date|after_or_equal:berlaku_mulai',
            'status'          => 'required|in:ready,in_use,maintenance',
        ]);

        $dataToSave = $validated;
        
        // Logika Checkbox: Kosongkan jika tidak dicentang
        if (!$request->has('layanan_baket')) {
            $dataToSave['harga_baket'] = null;
        }
        if (!$request->has('layanan_breker')) {
            $dataToSave['harga_breker'] = null;
        }

        PricingAlat::create($dataToSave);

        return redirect()->route('pricing.index')
            ->with('success', 'Pricing alat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = PricingAlat::findOrFail($id);
        $alat = AlatBerat::orderBy('nama_alat')->get();

        return view('admin.pricing.edit', compact('data', 'alat'));
    }

    public function update(Request $request, $id)
    {
        $pricing = PricingAlat::findOrFail($id);

        $validated = $request->validate([
            'alat_berat_id'   => 'required|exists:alat_berats,id',
            'layanan_baket'   => 'nullable',
            'harga_baket'     => 'nullable|integer|required_with:layanan_baket',
            'layanan_breker'  => 'nullable',
            'harga_breker'    => 'nullable|integer|required_with:layanan_breker',
            'berlaku_mulai'   => 'required|date',
            'berlaku_selesai' => 'nullable|date|after_or_equal:berlaku_mulai',
            'status'          => 'required|in:ready,in_use,maintenance',
        ]);

        $dataToSave = $validated;
        
        // Logika Checkbox: Kosongkan jika tidak dicentang
        if (!$request->has('layanan_baket')) {
            $dataToSave['harga_baket'] = null;
        }
        if (!$request->has('layanan_breker')) {
            $dataToSave['harga_breker'] = null;
        }

        $pricing->update($dataToSave);

        return redirect()->route('pricing.index')
            ->with('success', 'Pricing alat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pricing = PricingAlat::findOrFail($id);
        $pricing->delete();

        return redirect()->route('pricing.index')
            ->with('success', 'Pricing alat berhasil dihapus.');
    }
}