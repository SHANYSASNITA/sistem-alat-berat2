@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dp.index') }}">Data Pembayaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Pembayaran</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8 mx-auto stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Edit Data Pembayaran Sewa</h6>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal menyimpan perubahan!</strong> Periksa isian form di bawah:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="bg-light p-3 rounded border mb-4">
                        <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">
                            <i data-lucide="file-text" class="icon-sm me-1"></i> Informasi Transaksi
                        </h6>
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <span class="text-muted d-block small">Nama Pelanggan</span>
                                <span class="fw-bold text-dark">{{ $data->transaksi->pelanggan->nama ?? '-' }}</span>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <span class="text-muted d-block small">Alat Berat Dipakai</span>
                                <span class="fw-bold text-dark">[{{ $data->transaksi->alat->kode_unit ?? '-' }}] {{ $data->transaksi->alat->nama_alat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('dp.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="transaksi_sewa_id" value="{{ $data->transaksi_sewa_id }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Pembayaran <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i data-lucide="calendar" class="icon-sm"></i></span>
                                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $data->tanggal) }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-success fw-bold">Jumlah Bayar (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text border-success bg-success-subtle text-success">Rp</span>
                                    <input type="number" name="jumlah" class="form-control border-success @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', $data->jumlah) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="belum_lunas" {{ old('status', $data->status) == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas (DP / Cicilan)</option>
                                    <option value="lunas" {{ old('status', $data->status) == 'lunas' ? 'selected' : '' }}>Lunas (Pelunasan)</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block">Ganti Bukti Transfer <span class="text-muted small">(Opsional)</span></label>
                                @if($data->bukti_pembayaran)
                                    <div class="mb-2">
                                        <a href="{{ asset('storage/' . $data->bukti_pembayaran) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $data->bukti_pembayaran) }}" class="rounded border" style="height: 50px; object-fit: cover;" data-bs-toggle="tooltip" title="Lihat Struk Lama">
                                        </a>
                                    </div>
                                @endif
                                <input type="file" name="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror" accept="image/*">
                                <div class="form-text text-muted small">Biarkan kosong jika foto struk tidak ingin diganti.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="2">{{ old('keterangan', $data->keterangan) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('dp.show', $data->id) }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i data-lucide="refresh-cw" class="icon-sm me-1"></i> Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection