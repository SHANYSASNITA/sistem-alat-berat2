@extends('admin.layout')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dp.index') }}">Data Pembayaran</a></li>
        <li class="breadcrumb-item"><a href="javascript:history.back()">Rincian Laporan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Pembayaran</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-8 mx-auto stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Input Data Pembayaran Sewa</h6>

                <form action="{{ route('dp.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" name="from_detail" value="1">
                    {{-- PERBAIKAN: Gunakan transaksi_sewa_id --}}
                    <input type="hidden" name="transaksi_sewa_id" value="{{ request('transaksi_sewa_id') }}">

                    <div class="mb-3">
                        <label class="form-label text-primary fw-bold">1. Transaksi Sewa Terpilih</label>
                        <select class="form-select border-primary bg-light" disabled>
                            @foreach ($transaksi as $row)
                                {{-- PERBAIKAN: Gunakan transaksi_sewa_id --}}
                                @if(request('transaksi_sewa_id') == $row->id)
                                    <option selected>
                                        {{ $row->pelanggan->nama ?? '-' }} | {{ $row->alat->nama_alat ?? '-' }} | {{ $row->lokasi_proyek ?? '-' }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <hr class="mb-4">

                    <div class="p-3 bg-light rounded border mb-3">
                        <label class="form-label fw-bold mb-3 d-block border-bottom pb-2">2. Detail Pembayaran</label>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Pembayaran <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i data-lucide="calendar" class="icon-sm"></i></span>
                                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-success fw-bold">Jumlah Bayar (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text border-success bg-success-subtle text-success">Rp</span>
                                    <input type="number" name="jumlah" class="form-control border-success" required placeholder="Contoh: 5000000">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="belum_lunas">Belum Lunas (DP / Cicilan)</option>
                                    <option value="lunas">Lunas (Pelunasan)</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Upload Bukti Transfer <span class="text-danger">*</span></label>
                                <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        {{-- Tombol batal murni seperti timesheet --}}
                        <button type="button" onclick="history.back()" class="btn btn-secondary me-2">Batal</button>
                        <button type="submit" class="btn btn-primary text-white">
                            <i data-lucide="save" class="icon-sm me-1"></i> Simpan Pembayaran
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection