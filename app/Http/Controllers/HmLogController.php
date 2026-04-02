<?php

namespace App\Http\Controllers;

use App\Models\HmLog;
use App\Models\TransaksiSewa;
use Illuminate\Http\Request;

class HmLogController extends Controller
{
    /**
     * Menampilkan daftar log HM.
     */
    public function index()
    {
        $data = HmLog::with('transaksi')
            ->orderBy('created_at', 'desc')
            ->get();

        // UBAH: dari 'hm_log.index' menjadi 'admin.hm_log.index'
        return view('admin.hm_log.index', compact('data'));
    }

    /**
     * Menampilkan form input log HM baru.
     */
    public function create()
    {
        $transaksi = TransaksiSewa::orderBy('id')->get();
        // UBAH: dari 'hm_log.create' menjadi 'admin.hm_log.create'
        return view('admin.hm_log.create', compact('transaksi'));
    }

    /**
     * Menyimpan data log HM.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal_terakhir'  => 'required|date',
            'tanggal_sekarang'  => 'required|date',
            'hm_terkahir'       => 'required|integer|min:0',
            'hm_sekarang'       => 'required|integer|min:0'
        ]);

        HmLog::create($validated);

        return redirect()->route('hm.index')
            ->with('success', 'HM Log berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit log HM.
     */
    public function edit($id)
    {
        $data = HmLog::findOrFail($id);
        $transaksi = TransaksiSewa::orderBy('id')->get();

        // UBAH: dari 'hm_log.edit' menjadi 'admin.hm_log.edit'
        return view('admin.hm_log.edit', compact('data', 'transaksi'));
    }

    /**
     * Memperbarui data log HM di database.
     */
    public function update(Request $request, $id)
    {
        $hm = HmLog::findOrFail($id);

        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal_terakhir'  => 'required|date',
            'tanggal_sekarang'  => 'required|date',
            'hm_terkahir'       => 'required|integer|min:0',
            'hm_sekarang'       => 'required|integer|min:0'
        ]);

        $hm->update($validated);

        return redirect()->route('hm.index')
            ->with('success', 'HM Log berhasil diperbarui.');
    }

    /**
     * Menghapus data log HM.
     */
    public function destroy($id)
    {
        $hm = HmLog::findOrFail($id);
        $hm->delete();

        return redirect()->route('hm.index')
            ->with('success', 'HM Log berhasil dihapus.');
    }
}