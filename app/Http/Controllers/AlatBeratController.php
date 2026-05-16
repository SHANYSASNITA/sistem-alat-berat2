<?php

namespace App\Http\Controllers;

use App\Models\AlatBerat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatBeratController extends Controller
{
    public function index()
    {
        $data = AlatBerat::orderBy('created_at', 'asc')->get();
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
            'foto'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status'    => 'required|in:active,maintenance,broken',
        ]);

        // LOGIKA UPLOAD FOTO
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('alat_berat', 'public');
            $validated['foto'] = $path;
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
            if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
                Storage::disk('public')->delete($alat->foto);
            }
            
            $path = $request->file('foto')->store('alat_berat', 'public');
            $validated['foto'] = $path;
        }

        $alat->update($validated);

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        /** @var \App\Models\AlatBerat $alat */
        $alat = AlatBerat::findOrFail($id);
        
        if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
            Storage::disk('public')->delete($alat->foto);
        }

        $alat->delete();

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berat berhasil dihapus.');
    }
}