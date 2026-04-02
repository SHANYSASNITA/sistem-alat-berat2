@extends('admin.layout')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('timesheet.index') }}">Data Timesheet</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Data Proyek</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-8 mx-auto stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Edit Data Timesheet (HM Alat)</h6>

                <form action="{{ route('timesheet.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label text-primary fw-bold">1. Transaksi Sewa</label>
                        <select name="transaksi_sewa_id" class="form-select border-primary bg-light" style="pointer-events: none;">
                            @foreach ($transaksi as $row)
                                <option value="{{ $row->id }}" {{ $row->id == $data->transaksi_sewa_id ? 'selected' : '' }}>
                                    {{ $row->pelanggan->nama ?? '-' }} | {{ $row->alat->nama_alat ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">2. Tanggal Pengerjaan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-lucide="calendar" class="icon-sm"></i></span>
                            <input type="date" name="tanggal" class="form-control" value="{{ \Carbon\Carbon::parse($data->tanggal)->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded border mb-3">
                        <label class="form-label fw-bold mb-3 d-block border-bottom pb-2">3. Meteran Alat Berat (Hour Meter)</label>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">HM Awal</label>
                                <div class="input-group">
                                    <input type="number" step="0.1" name="hm_awal" class="form-control" value="{{ $data->hm_awal }}">
                                    <span class="input-group-text text-secondary">HM</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label text-primary fw-bold">HM Akhir</label>
                                <div class="input-group">
                                    <input type="number" step="0.1" name="hm_akhir" class="form-control border-primary" value="{{ $data->hm_akhir }}">
                                    <span class="input-group-text border-primary bg-primary-subtle text-primary">HM</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('timesheet.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary text-white">
                            <i data-lucide="save" class="icon-sm me-1"></i> Perbarui Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection