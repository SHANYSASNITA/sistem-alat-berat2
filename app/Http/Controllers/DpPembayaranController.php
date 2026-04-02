<?php

namespace App\Http\Controllers;

use App\Models\DpPembayaran;
use App\Models\TransaksiSewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class DpPembayaranController extends Controller
{
    public function index()
{
    $data = DpPembayaran::with(['transaksi.pelanggan', 'transaksi.alat', 'transaksi.operator'])
        ->orderBy('created_at', 'asc') // Mengambil data pertama (DP)
        ->get()                      
        ->unique('transaksi_sewa_id')  
        ->values();                    

    foreach ($data as $row) {
        $pembayaranTerakhir = DpPembayaran::where('transaksi_sewa_id', $row->transaksi_sewa_id)
                                ->orderBy('created_at', 'desc') // Mencari data terbaru
                                ->first();
        $row->status_terakhir_proyek = $pembayaranTerakhir->status ?? 'belum_lunas';
    }

    return view('admin.dp_pembayaran.index', compact('data'));
}

    // 👇 INI DIA FUNGSI YANG HILANG SEBELUMNYA! 👇
    public function create()
{
    // Mengambil data transaksi untuk dropdown
    $transaksi = \App\Models\TransaksiSewa::orderBy('id', 'desc')->get();
    return view('admin.dp_pembayaran.create', compact('transaksi'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal'           => 'required|date',
            'jumlah'            => 'required|integer|min:0',
            'keterangan'        => 'nullable|string',
            'status'            => 'required|in:lunas,belum_lunas',
            'bukti_pembayaran'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayarans', 'public');
            $validated['bukti_pembayaran'] = $path;
        }

        $dp = DpPembayaran::create($validated);

        // Setelah berhasil simpan, langsung loncat ke Halaman Rincian/Detail
        return redirect()->route('dp.show', $dp->id)
            ->with('success', 'Pembayaran berhasil ditambahkan dan otomatis masuk ke rincian!');
    }

    public function edit($id)
    {
        $data = DpPembayaran::findOrFail($id);
        $transaksi = TransaksiSewa::orderBy('id')->get();

        return view('admin.dp_pembayaran.edit', compact('data', 'transaksi'));
    }

    public function update(Request $request, $id)
    {
        $dp = DpPembayaran::findOrFail($id);

        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal'           => 'required|date',
            'jumlah'            => 'required|integer|min:0',
            'keterangan'        => 'nullable|string',
            'status'            => 'required|in:lunas,belum_lunas',
            'bukti_pembayaran'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            // Hapus gambar lama jika ada
            if ($dp->bukti_pembayaran && Storage::disk('public')->exists($dp->bukti_pembayaran)) {
                Storage::disk('public')->delete($dp->bukti_pembayaran);
            }
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayarans', 'public');
            $validated['bukti_pembayaran'] = $path;
        }

        $dp->update($validated);

        // Setelah berhasil diedit, kembalikan ke Halaman Rincian/Detail
        return redirect()->route('dp.show', $dp->id)
            ->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dp = DpPembayaran::findOrFail($id);

        // Hapus foto struk fisiknya dari folder storage
        if ($dp->bukti_pembayaran && Storage::disk('public')->exists($dp->bukti_pembayaran)) {
            Storage::disk('public')->delete($dp->bukti_pembayaran);
        }

        $dp->delete();

        return redirect()->route('dp.index')
            ->with('success', 'Data riwayat pembayaran berhasil dihapus.');
    }

    public function show($id)
    {
        $dp = DpPembayaran::findOrFail($id);

        // Tarik SEMUA riwayat cicilan untuk proyek ini dan urutkan dari DP awal ke Pelunasan
        $data = DpPembayaran::with(['transaksi.pelanggan', 'transaksi.alat'])
                    ->where('transaksi_sewa_id', $dp->transaksi_sewa_id)
                    ->orderBy('tanggal', 'asc') 
                    ->get();

        return view('admin.dp_pembayaran.detail.detail', compact('data', 'dp')); 
    }
}