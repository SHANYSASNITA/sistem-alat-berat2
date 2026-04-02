@extends('admin.layout')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hm.index') }}">HM Log</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Log</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-8 mx-auto stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Input Hour Meter (HM) Unit</h6>

                <form action="{{ route('hm.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-bold text-primary">Pilih Transaksi Aktif <span class="text-danger">*</span></label>
                        <select name="transaksi_sewa_id" class="form-select @error('transaksi_sewa_id') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Transaksi --</option>
                            @foreach ($transaksi as $t)
                                <option value="{{ $t->id }}" {{ old('transaksi_sewa_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->pelanggan->nama ?? '-' }} | {{ $t->alat->nama_alat ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('transaksi_sewa_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row bg-light p-3 rounded mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Tanggal HM Terakhir</label>
                            <input type="date" name="tanggal_terakhir" class="form-control" required value="{{ old('tanggal_terakhir') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Angka HM Terakhir</label>
                            <div class="input-group">
                                <input type="number" step="0.1" name="hm_terkahir" class="form-control" required value="{{ old('hm_terkahir', 0) }}">
                                <span class="input-group-text">HM</span>
                            </div>
                        </div>
                    </div>

                    <div class="row border-top pt-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal HM Sekarang <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_sekarang" class="form-control border-primary" required value="{{ old('tanggal_sekarang', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Angka HM Sekarang <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.1" name="hm_sekarang" class="form-control border-primary text-primary fw-bold" required value="{{ old('hm_sekarang') }}" placeholder="0.0">
                                <span class="input-group-text bg-primary text-white border-primary">HM</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('hm.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary text-white">
                            <i data-lucide="save" class="icon-sm me-1"></i> Simpan HM Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection