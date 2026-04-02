@extends('admin.layout')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('timesheet.index') }}">Data Timesheet</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-8 mx-auto stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Input Data Timesheet (HM Alat)</h6>

                {{-- Step 1: Pilih Transaksi --}}
                <form method="GET" action="{{ route('timesheet.create') }}" class="mb-4">
                    <div class="mb-3">
                        <label class="form-label text-primary fw-bold">1. Pilih Transaksi Sewa</label>
                        <select name="transaksi_sewa_id" class="form-select border-primary" onchange="this.form.submit()">
                            <option value="">-- Pilih Transaksi Aktif --</option>
                            @foreach ($transaksi as $row)
                                <option value="{{ $row->id }}" {{ request('transaksi_sewa_id') == $row->id ? 'selected' : '' }}>
                                    {{ $row->pelanggan->nama ?? '-' }} | {{ $row->alat->nama_alat ?? '-' }} | Lokasi: {{ $row->lokasi_proyek ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Form input HM akan muncul setelah transaksi dipilih.</small>
                    </div>
                </form>

                {{-- Step 2: Input Data --}}
                @if (request()->filled('transaksi_sewa_id'))
                    <hr>
                    <form action="{{ route('timesheet.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="transaksi_sewa_id" value="{{ request('transaksi_sewa_id') }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold">2. Tanggal Pengerjaan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i data-lucide="calendar" class="icon-sm"></i></span>
                                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded border mb-3">
                            <label class="form-label fw-bold mb-3 d-block border-bottom pb-2">3. Meteran Alat Berat (Hour Meter) - <span class="text-muted fw-normal small">Opsional, bisa diisi nanti</span></label>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">HM Awal</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="hm_awal" class="form-control" placeholder="Contoh: 1000.5">
                                        <span class="input-group-text text-secondary">HM</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label text-primary fw-bold">HM Akhir</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="hm_akhir" class="form-control border-primary" placeholder="Contoh: 1012.0">
                                        <span class="input-group-text border-primary bg-primary-subtle text-primary">HM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('timesheet.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i data-lucide="save" class="icon-sm me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection