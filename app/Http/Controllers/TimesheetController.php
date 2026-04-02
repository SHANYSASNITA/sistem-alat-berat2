<?php

namespace App\Http\Controllers;

// Import class baru yang menggunakan PhpSpreadsheet
use App\Exports\TimesheetTemplateExport; 
use App\Models\Timesheet;
use App\Models\TransaksiSewa;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    /**
     * Menampilkan daftar Timesheet.
     */
    public function index()
    {
        // Menampilkan 1 baris saja per Transaksi (Proyek) untuk halaman utama
        $data = Timesheet::with('transaksi.pelanggan', 'transaksi.alat')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->unique('transaksi_sewa_id'); // Mengelompokkan agar tidak ganda

        return view('admin.timesheet.index', compact('data'));
    }

    /**
     * Menampilkan form tambah Timesheet.
     */
    public function create(Request $request)
    {
        $transaksi = TransaksiSewa::orderBy('tanggal_mulai', 'desc')->get();
        $jenisPekerjaan = [];

        // JIKA tombol diklik dari halaman DETAIL (membawa parameter transaksi_id)
        if ($request->filled('transaksi_id')) {
            $t = TransaksiSewa::find($request->transaksi_id);
            if ($t) {
                $jp = is_string($t->jenis_pekerjaan) ? json_decode($t->jenis_pekerjaan, true) : $t->jenis_pekerjaan;
                $jenisPekerjaan = is_array($jp) ? array_map('strtolower', $jp) : [];
            }
            
            // Arahkan ke file create di dalam folder 'detail'
            return view('admin.timesheet.detail.create', compact('transaksi', 'jenisPekerjaan'));
        }

        // JIKA tombol diklik dari halaman INDEX UTAMA
        // Arahkan ke file create di folder utama
        return view('admin.timesheet.create', compact('transaksi'));
    }

    /**
     * Menampilkan form edit Timesheet.
     */
    public function edit(Request $request, $id) // WAJIB ada Request $request disini
    {
        $data = Timesheet::findOrFail($id);
        $transaksi = TransaksiSewa::orderBy('tanggal_mulai', 'desc')->get();
        $jenisPekerjaan = [];

        if ($data->transaksi_sewa_id) {
            $t = TransaksiSewa::find($data->transaksi_sewa_id);
            if ($t) {
                $jp = is_string($t->jenis_pekerjaan) ? json_decode($t->jenis_pekerjaan, true) : $t->jenis_pekerjaan;
                $jenisPekerjaan = is_array($jp) ? array_map('strtolower', $jp) : [];
            }
        }

        // ALUR 1: Jika tombol diklik dari DALAM folder detail
        if ($request->has('from_detail')) {
            return view('admin.timesheet.detail.edit', compact('data', 'transaksi', 'jenisPekerjaan'));
        }

        // ALUR 2: Jika tombol diklik dari LUAR (Halaman Index Utama)
        return view('admin.timesheet.edit', compact('data', 'transaksi'));
    }

    public function destroy($id)
    {
        $data = Timesheet::findOrFail($id);
        $data->delete();

        return redirect()->route('timesheet.index')
                         ->with('success', 'Data Timesheet berhasil dihapus!');
    }


     public function update(Request $request, $id)
    {
        $request->validate([
            'transaksi_sewa_id' => 'required',
            'tanggal'           => 'required|date',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $timesheet = Timesheet::findOrFail($id);
        $data = $request->all();

        // Logika Ganti Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($timesheet->foto && Storage::disk('public')->exists($timesheet->foto)) {
                Storage::disk('public')->delete($timesheet->foto);
            }
            $data['foto'] = $request->file('foto')->store('timesheet_photos', 'public');
        }

        $timesheet->update($data);

        if ($request->has('from_detail')) {
            $masterTimesheet = Timesheet::where('transaksi_sewa_id', $timesheet->transaksi_sewa_id)->first();
            return redirect()->route('timesheet.show', $masterTimesheet->id)->with('success', 'Log harian berhasil diperbarui!');
        }

        return redirect()->route('timesheet.index')->with('success', 'Data proyek berhasil diperbarui!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_sewa_id' => 'required',
            'tanggal'           => 'required|date',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        $data = $request->all();

        // Logika Upload Foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('timesheet_photos', 'public');
        }

        $timesheet = Timesheet::create($data);

        if ($request->has('from_detail')) {
            $masterTimesheet = Timesheet::where('transaksi_sewa_id', $timesheet->transaksi_sewa_id)->first();
            return redirect()->route('timesheet.show', $masterTimesheet->id)->with('success', 'Log harian berhasil disimpan!');
        }

        return redirect()->route('timesheet.index')->with('success', 'Data Timesheet berhasil ditambahkan!');
    }

    /**
     * Mengekspor Timesheet ke Excel menggunakan Template
     */
    public function export($transaksi_id)
    {
        // Memanggil class TimesheetTemplateExport
        $exportData = new TimesheetTemplateExport();
        
        // Memproses dan langsung me-return file Excel ke browser pengguna
        return $exportData->export($transaksi_id);
    }

    public function show($id)
{
    // 1. Tambahkan relasi operator di sini agar terbaca di info card
    $timesheet = Timesheet::with(['transaksi.pelanggan', 'transaksi.alat', 'transaksi.operator'])->findOrFail($id);

    // 2. Tarik log harian (sembunyikan yang kosong)
    $data = Timesheet::with(['transaksi.pelanggan', 'transaksi.alat'])
                ->where('transaksi_sewa_id', $timesheet->transaksi_sewa_id)
                ->where(function ($query) {
                    $query->where('jam_baket', '>', 0)
                          ->orWhere('jam_breker', '>', 0);
                })
                ->orderBy('tanggal', 'asc')
                ->get();

    return view('admin.timesheet.detail.detail', compact('data', 'timesheet')); 
}
}