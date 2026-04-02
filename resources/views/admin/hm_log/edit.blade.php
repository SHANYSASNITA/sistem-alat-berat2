@extends('admin.layout')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hm.index') }}">HM Log</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Log</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-8 mx-auto stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Update Log Hour Meter</h6>

                <form action="{{ route('hm.update', $data->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">Transaksi</label>
                        <select name="transaksi_sewa_id" class="form-select bg-light" required readonly>
                            @foreach ($transaksi as $t)
                                <option value="{{ $t->id }}" {{ $data->transaksi_sewa_id == $t->id ? 'selected' : '' }}>
                                    {{ $t->pelanggan->nama ?? '-' }} | {{ $t->alat->nama_alat ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">ID Transaksi tidak dapat diubah pada mode edit.</small>
                    </div>

                    <div class="row bg-light p-3 rounded mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal HM Terakhir</label>
                            <input type="date" name="tanggal_terakhir" class="form-control" required value="{{ old('tanggal_terakhir', $data->tanggal_terakhir) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Angka HM Terakhir</label>
                            <div class="input-group">
                                <input type="number" step="0.1" name="hm_terkahir" class="form-control" value="{{ old('hm_terkahir', $row->hm_terkahir ?? $data->hm_terkahir) }}">
                                <span class="input-group-text text-secondary">HM</span>
                            </div>
                        </div>
                    </div>

                    <div class="row border-top pt-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal HM Sekarang</label>
                            <input type="date" name="tanggal_sekarang" class="form-control" required value="{{ old('tanggal_sekarang', $data->tanggal_sekarang) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Angka HM Sekarang</label>
                            <div class="input-group">
                                <input type="number" step="0.1" name="hm_sekarang" class="form-control border-warning text-warning fw-bold" required value="{{ old('hm_sekarang', $data->hm_sekarang) }}">
                                <span class="input-group-text bg-warning-subtle border-warning">HM</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('hm.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary text-white">
                            <i data-lucide="refresh-cw" class="icon-sm me-1"></i> Update HM Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection