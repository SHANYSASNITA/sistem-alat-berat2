@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dp.index') }}">Data DP</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit DP</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8 mx-auto stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Update Data Pembayaran DP</h6>

                    <form action="{{ route('dp.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Transaksi</label>
                            <select name="transaksi_sewa_id" class="form-select" required disabled>
                                @foreach ($transaksi as $t)
                                    <option value="{{ $t->id }}" {{ $data->transaksi_sewa_id == $t->id ? 'selected' : '' }}>
                                        {{ $t->pelanggan->nama ?? 'Pelanggan' }} | {{ $t->alat->nama_alat ?? 'Alat' }} | {{ $t->operator->nama ?? 'Operator'}} | {{ $t->lokasi_proyek ?? 'Lokasi Proyek' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">ID Transaksi tidak dapat diubah untuk menjaga integritas data.</small>
                            <input type="hidden" name="transaksi_sewa_id" value="{{ $data->transaksi_sewa_id }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $data->tanggal) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah (Rp)</label>
                                <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $data->jumlah) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $data->keterangan) }}</textarea>
                        </div>

                        <div class="col-md-3 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="lunas" {{ old('status', $data->status) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    <option value="belum_lunas" {{ old('status', $data->status) == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                </select>
                            </div>

                        <div class="mb-4">
                            <label class="form-label d-block">Bukti Pembayaran</label>
                            
                            @if($data->bukti_pembayaran)
                                <div class="mb-3">
                                    <p class="text-muted small mb-2">Bukti Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $data->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-thumbnail" style="height: 150px; object-fit: contain;">
                                </div>
                            @endif

                            <label class="form-label">Ganti Bukti Pembayaran <span class="text-muted small">(Opsional)</span></label>
                            <input type="file" name="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror" accept="image/*">
                            <div class="form-text text-muted small">Biarkan kosong jika tidak ingin mengubah bukti yang sudah ada.</div>
                            @error('bukti_pembayaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('dp.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i data-lucide="refresh-cw" class="icon-sm me-1"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection