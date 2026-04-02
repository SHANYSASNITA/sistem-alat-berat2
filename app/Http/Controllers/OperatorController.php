<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    /**
     * Menampilkan daftar operator.
     */
    public function index()
    {
        $data = Operator::orderBy('nama')->get();
        // PERBAIKAN: Gunakan admin.
        return view('admin.operator.index', compact('data')); 
    }

    /**
     * Menampilkan form tambah operator.
     */
    public function create()
    {
        // PERBAIKAN: Tambahkan admin. (Ini penyebab error Anda)
        return view('admin.operator.create'); 
    }

    /**
     * Menyimpan data operator baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'no_hp'          => 'nullable|string|max:20',
            'alamat'         => 'nullable|string',
            'tanggal_lahir'  => 'required|date',
            'ktp_operator'   => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // Cek file menggunakan nama 'ktp_operator'
        if ($request->hasFile('ktp_operator')) {
            // Simpan ke folder public/ktp_operators
            $path = $request->file('ktp_operator')->store('ktp_operators', 'public');
            $validated['ktp_operator'] = $path;
        }

        Operator::create($validated);

        return redirect()->route('operator.index')
            ->with('success', 'Data Operator beserta KTP berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit operator.
     */
    public function edit($id)
    {
        $data = Operator::findOrFail($id);
        // PERBAIKAN: Gunakan admin.
        return view('admin.operator.edit', compact('data'));
    }

    /**
     * Memperbarui data operator.
     */
    public function update(Request $request, $id)
    {
        $operator = Operator::findOrFail($id);

        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|string',
            'ktp_operator' => 'nullable|string',
        ]);

        $operator->update($validated);

        return redirect()->route('operator.index')
            ->with('success', 'Operator berhasil diperbarui.');
    }

    /**
     * Menghapus data operator.
     */
    public function destroy($id)
    {
        $operator = Operator::findOrFail($id);
        $operator->delete();

        return redirect()->route('operator.index')
            ->with('success', 'Operator berhasil dihapus.');
    }
}