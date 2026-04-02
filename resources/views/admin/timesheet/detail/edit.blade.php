@extends('admin.layout')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('timesheet.index') }}">Data Timesheet</a></li>
        <li class="breadcrumb-item"><a href="javascript:history.back()">Rincian Laporan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Log Harian</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-6 mx-auto stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Edit Log Penggunaan Alat</h6>

                <form action="{{ route('timesheet.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="from_detail" value="1">
                    <input type="hidden" name="transaksi_sewa_id" value="{{ $data->transaksi_sewa_id }}">

                    <div class="mb-3">
                        <label class="form-label text-primary fw-bold">1. Transaksi Sewa Terpilih</label>
                        <div class="input-group">
                            <span class="input-group-text border-primary bg-light">
                                <i data-lucide="" class="text-secondary" width="16" height="16"></i>
                            </span>
                            <select class="form-select border-primary bg-light" style="background-image: none;" disabled>
                                @foreach ($transaksi as $row)
                                    <option value="{{ $row->id }}" {{ $row->id == $data->transaksi_sewa_id ? 'selected' : '' }}>
                                        {{ $row->pelanggan->nama ?? '-' }} | {{ $row->alat->nama_alat ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label fw-bold">2. Tanggal Kerja</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-lucide="calendar" class="icon-sm"></i></span>
                            <input type="date" name="tanggal" class="form-control" value="{{ \Carbon\Carbon::parse($data->tanggal)->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        @if (in_array('baket', $jenisPekerjaan))
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Baket</label>
                                <div class="input-group">
                                    <input type="number" step="0.5" name="jam_baket" class="form-control" value="{{ $data->jam_baket }}">
                                    <span class="input-group-text">Jam</span>
                                </div>
                            </div>
                        @endif

                        @if (in_array('breker', $jenisPekerjaan))
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-warning fw-bold">Jam Breker</label>
                                <div class="input-group">
                                    <input type="number" step="0.5" name="jam_breker" class="form-control border-warning" value="{{ $data->jam_breker }}">
                                    <span class="input-group-text border-warning bg-warning-subtle text-warning">Jam</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">3. Foto</label> @if($data->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $data->foto) }}" class="rounded border" style="height: 80px;">
                            </div>
                        @endif
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" onclick="history.back()" class="btn btn-secondary me-2">Batal</button>
                        <button type="submit" class="btn btn-primary text-white">
                            <i data-lucide="refresh-cw" class="icon-sm me-1"></i> Update Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection