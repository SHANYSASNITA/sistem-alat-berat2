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
            // PERBAIKAN: Baca status dari data master/pancingan (asc), bukan cicilan terakhir
            $pembayaranMaster = DpPembayaran::where('transaksi_sewa_id', $row->transaksi_sewa_id)
                ->orderBy('created_at', 'asc') 
                ->first();
            $row->status_terakhir_proyek = $pembayaranMaster->status ?? 'belum_lunas';
        }

        return view('admin.dp_pembayaran.index', compact('data'));
    }

    public function show($id)
    {
        $dp = DpPembayaran::findOrFail($id);
        
        $data = DpPembayaran::with(['transaksi.pelanggan', 'transaksi.alat'])
            ->where('transaksi_sewa_id', $dp->transaksi_sewa_id)
            ->where('jumlah', '>', 0) 
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('admin.dp_pembayaran.detail.detail', compact('data', 'dp'));
    }

    public function create(Request $request)
    {
        $transaksi = TransaksiSewa::orderBy('id', 'desc')->get();

        if ($request->filled('transaksi_sewa_id')) {
            if ($request->query('source') == 'index') {
                return view('admin.dp_pembayaran.create', compact('transaksi'));
            }

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
                'jumlah'            => 'required|integer|min:1', 
                'keterangan'        => 'nullable|string',
                'bukti_pembayaran'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            
            // Ambil status dari master agar tidak error di database (karena kolom status wajib)
            $masterDp = DpPembayaran::where('transaksi_sewa_id', $request->transaksi_sewa_id)->first();
            $validated['status'] = $masterDp->status ?? 'belum_lunas';
            
        } else {
            // Ini adalah proses pancingan dari halaman index
            $validated = $request->validate([
                'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
                'tanggal'           => 'required|date',
                'status'            => 'required|in:lunas,belum_lunas',
            ]);
            $validated['jumlah'] = 0; 
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

        if ($request->has('from_detail')) {
            $validated = $request->validate([
                'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
                'tanggal'           => 'required|date',
                'jumlah'            => 'required|integer|min:1', 
                'keterangan'        => 'nullable|string',
                'bukti_pembayaran'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);
        } 
        else {
            $validated = $request->validate([
                'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
                'tanggal'           => 'required|date',
                'status'            => 'required|in:lunas,belum_lunas',
            ]);
            
            // PERBAIKAN: Jika status master diupdate dari index, update juga status semua cicilan anaknya
            DpPembayaran::where('transaksi_sewa_id', $dp->transaksi_sewa_id)
                ->update(['status' => $request->status]);
        }

        if ($request->hasFile('bukti_pembayaran')) {
            if ($dp->bukti_pembayaran && Storage::disk('public')->exists($dp->bukti_pembayaran)) {
                Storage::disk('public')->delete($dp->bukti_pembayaran);
            }
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayarans', 'public');
            $validated['bukti_pembayaran'] = $path;
        }

        $dp->update($validated);

        if ($request->has('from_detail')) {
            $masterDp = DpPembayaran::where('transaksi_sewa_id', $dp->transaksi_sewa_id)->first();
            return redirect()->route('dp.show', $masterDp->id)
                ->with('success', 'Data cicilan berhasil diperbarui!');
        }

        return redirect()->route('dp.index')
            ->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $dp = DpPembayaran::findOrFail($id);
        $transaksi_sewa_id = $dp->transaksi_sewa_id;

        if ($request->has('from_detail')) {
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