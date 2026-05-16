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
            ->orderBy('created_at', 'asc')
            ->get()
            ->unique('transaksi_sewa_id')
            ->values();

        foreach ($data as $row) {
            $pembayaranTerakhir = DpPembayaran::where('transaksi_sewa_id', $row->transaksi_sewa_id)
                ->orderBy('created_at', 'desc')
                ->first();
            $row->status_terakhir_proyek = $pembayaranTerakhir->status ?? 'belum_lunas';
        }

        return view('admin.dp_pembayaran.index', compact('data'));
    }

    public function show($id)
    {
        $dp = DpPembayaran::findOrFail($id);
        $data = DpPembayaran::with(['transaksi.pelanggan', 'transaksi.alat'])
            ->where('transaksi_sewa_id', $dp->transaksi_sewa_id)
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('admin.dp_pembayaran.detail.detail', compact('data', 'dp'));
    }

public function create(Request $request)
{
    $transaksi = TransaksiSewa::orderBy('id', 'desc')->get();

    if ($request->filled('transaksi_sewa_id')) {

        // Dari halaman index → tetap di create folder luar
        if ($request->query('source') == 'index') {
            return view('admin.dp_pembayaran.create', compact('transaksi'));
        }

        // Dari halaman detail → ke detail/create
        $masterDp = DpPembayaran::where('transaksi_sewa_id', $request->transaksi_sewa_id)->first();
        $dp_id = $masterDp->id ?? null;

        return view('admin.dp_pembayaran.detail.create', compact('transaksi', 'dp_id'));
    }

    return view('admin.dp_pembayaran.create', compact('transaksi'));
}

  public function store(Request $request)
{
    if ($request->has('from_detail')) {
        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal'           => 'required|date',
            'jumlah'            => 'required|integer|min:0',
            'keterangan'        => 'nullable|string',
            'status'            => 'required|in:lunas,belum_lunas',
            'bukti_pembayaran'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    } else {
        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal'           => 'required|date',
            'status'            => 'required|in:lunas,belum_lunas',
        ]);
        $validated['jumlah'] = 0; // ← TAMBAH INI
    }

    if ($request->hasFile('bukti_pembayaran')) {
        $path = $request->file('bukti_pembayaran')->store('bukti_pembayarans', 'public');
        $validated['bukti_pembayaran'] = $path;
    }

    $dp = DpPembayaran::create($validated);

    if ($request->has('from_detail')) {
        $masterDp = DpPembayaran::where('transaksi_sewa_id', $dp->transaksi_sewa_id)->first();
        return redirect()->route('dp.show', $masterDp->id)
            ->with('success', 'Pembayaran berhasil ditambahkan!');
    }

    return redirect()->route('dp.index')
        ->with('success', 'Pembayaran berhasil ditambahkan!');
}
    public function edit(Request $request, $id)
    {
        $data = DpPembayaran::findOrFail($id);
        $transaksi = TransaksiSewa::orderBy('id')->get();

        if ($request->has('from_detail')) {
            return view('admin.dp_pembayaran.detail.edit', compact('data', 'transaksi'));
        }

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
            if ($dp->bukti_pembayaran && Storage::disk('public')->exists($dp->bukti_pembayaran)) {
                Storage::disk('public')->delete($dp->bukti_pembayaran);
            }
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayarans', 'public');
            $validated['bukti_pembayaran'] = $path;
        }

        $dp->update($validated);

        return redirect()->route('dp.show', $dp->id)
            ->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
{
    $dp = DpPembayaran::findOrFail($id);
    $transaksi_sewa_id = $dp->transaksi_sewa_id;

        if ($request->has('from_detail')) {
            // Hapus dari halaman detail → hapus 1 record saja
            if ($dp->bukti_pembayaran && Storage::disk('public')->exists($dp->bukti_pembayaran)) {
                Storage::disk('public')->delete($dp->bukti_pembayaran);
            }
            $dp->delete();

            $masterDp = DpPembayaran::where('transaksi_sewa_id', $transaksi_sewa_id)->first();

            if ($masterDp) {
                return redirect()->route('dp.show', $masterDp->id)
                    ->with('success', 'Data cicilan berhasil dihapus.');
            }

            return redirect()->route('dp.index')
                ->with('success', 'Data cicilan berhasil dihapus.');

        } else {
            // Hapus dari halaman index → hapus SEMUA riwayat transaksi ini
            $semuaDp = DpPembayaran::where('transaksi_sewa_id', $transaksi_sewa_id)->get();

            foreach ($semuaDp as $item) {
                if ($item->bukti_pembayaran && Storage::disk('public')->exists($item->bukti_pembayaran)) {
                    Storage::disk('public')->delete($item->bukti_pembayaran);
                }
                $item->delete();
            }

            return redirect()->route('dp.index')
                ->with('success', 'Semua data pembayaran berhasil dihapus.');
        }
    }
}