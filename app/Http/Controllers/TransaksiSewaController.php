<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\AlatBerat;
use App\Models\Pelanggan;
use App\Models\PricingAlat;
use App\Models\LokasiProyek;
use Illuminate\Http\Request;
use App\Models\TransaksiSewa;

class TransaksiSewaController extends Controller
{
    /**
     * Menampilkan daftar transaksi sewa.
     */
    public function index()
    {
        $data = TransaksiSewa::with(['alat', 'operator', 'pelanggan'])
            ->orderBy('created_at', 'desc')
            ->get();

        // UBAH: Diarahkan ke folder admin.transaksi
        return view('admin.transaksi.index', compact('data'));
    }

    /**
     * Menampilkan form tambah transaksi baru.
     */
    public function create()
    {
        $alat = AlatBerat::all();
        $operator = Operator::all();
        $pelanggan = Pelanggan::all();

        // UBAH: Diarahkan ke folder admin.transaksi
        return view('admin.transaksi.create', compact('alat', 'operator', 'pelanggan'));
    }

    /**
     * Menyimpan data transaksi ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alat_berat_id'   => 'required|exists:alat_berats,id',
            'operator_id'     => 'required|exists:operators,id',
            'pelanggan_id'    => 'required|exists:pelanggans,id',
            'jenis_sewa'      => 'required',
            'jenis_pekerjaan' => 'required|array|min:1',
            'jenis_pekerjaan.*' => 'in:baket,breker',
            'lokasi_proyek'   => 'required',
            'mobilisasi'      => 'required',
            'demobilisasi'    => 'required',
            'biaya_modem'     => 'nullable|integer|min:0',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'harga_sewa_baket' => 'nullable|integer|min:0',
            'harga_sewa_breker'  => 'nullable|integer|min:0',
            'status'          => 'required|in:berjalan,selesai,batal',
        ]);

        TransaksiSewa::create($validated);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi sewa berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit transaksi.
     */
    public function edit($id)
    {
        $data = TransaksiSewa::findOrFail($id);

        $alat = AlatBerat::all();
        $operator = Operator::all();
        $pelanggan = Pelanggan::all();
        $lokasi = LokasiProyek::all();

        // UBAH: Diarahkan ke folder admin.transaksi
        return view('admin.transaksi.edit', compact('data', 'alat', 'operator', 'pelanggan'));
    }

    /**
     * Memperbarui data transaksi.
     */
    public function update(Request $request, $id)
    {
        $transaksi = TransaksiSewa::findOrFail($id);

        $validated = $request->validate([
            'alat_berat_id'   => 'required|exists:alat_berats,id',
            'operator_id'     => 'required|exists:operators,id',
            'pelanggan_id'    => 'required|exists:pelanggans,id',
            'jenis_sewa'      => 'required',
            'jenis_pekerjaan' => 'required|array|min:1',
            'jenis_pekerjaan.*' => 'in:baket,breker',
            'lokasi_proyek'   => 'required',
            'mobilisasi'      => 'required',
            'demobilisasi'    => 'required',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'harga_sewa_baket' => 'nullable|integer|min:0',
            'harga_sewa_breker'  => 'nullable|integer|min:0',
            'status'          => 'required|in:berjalan,selesai,batal',
        ]);

        $transaksi->update($validated);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi sewa berhasil diperbarui.');
    }

    /**
     * Menghapus data transaksi.
     */
    public function destroy($id)
    {
        $transaksi = TransaksiSewa::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi sewa berhasil dihapus.');
    }
}