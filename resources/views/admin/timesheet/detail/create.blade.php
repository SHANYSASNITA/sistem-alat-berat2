@extends('admin.layout')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('timesheet.index') }}">Data Timesheet</a></li>
        <li class="breadcrumb-item"><a href="{{ route('timesheet.show', request('transaksi_id')) }}">Rincian Laporan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Log Harian</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-6 mx-auto stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Input Penggunaan Alat (Log Harian)</h6>

                <form action="{{ route('timesheet.store') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="from_detail" value="1">
                    
                    <input type="hidden" name="transaksi_sewa_id" value="{{ request('transaksi_id') }}">

                    {{-- Step 1: Info Transaksi (Dibuat Read-Only karena sudah otomatis terpilih) --}}
                    <div class="mb-3">
                        <label class="form-label text-primary fw-bold">1. Transaksi Sewa Terpilih</label>
                        <select class="form-select border-primary bg-light" disabled>
                            @foreach ($transaksi as $row)
                                @if(request('transaksi_id') == $row->id)
                                    <option selected>
                                        {{ $row->pelanggan->nama ?? '-' }} | {{ $row->alat->nama_alat ?? '-' }} | {{ $row->lokasi_proyek ?? '-' }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <hr>

                    {{-- Step 2: Input Data Jam Kerja --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">2. Tanggal Kerja</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-lucide="calendar" class="icon-sm"></i></span>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        @if (in_array('baket', $jenisPekerjaan))
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Baket</label>
                                <div class="input-group">
                                    <input type="number" step="0.5" name="jam_baket" class="form-control" value="0">
                                    <span class="input-group-text text-secondary">Jam</span>
                                </div>
                            </div>
                        @endif

                        @if (in_array('breker', $jenisPekerjaan))
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-warning fw-bold">Jam Breker</label>
                                <div class="input-group">
                                    <input type="number" step="0.5" name="jam_breker" class="form-control border-warning" value="0">
                                    <span class="input-group-text border-warning bg-warning-subtle text-warning">Jam</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" onclick="history.back()" class="btn btn-secondary me-2">Batal</button>
                        <button type="submit" class="btn btn-primary text-white">
                            <i data-lucide="save" class="icon-sm me-1"></i> Simpan Log
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection