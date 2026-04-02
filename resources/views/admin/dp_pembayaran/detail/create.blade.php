@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dp.index') }}">Data Pembayaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pembayaran</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8 mx-auto stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Input Data Pembayaran Sewa</h6>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal menyimpan data!</strong> Periksa isian form di bawah:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="GET" action="{{ route('dp.create') }}" class="mb-4">
                        <div class="mb-3">
                            <label class="form-label text-primary fw-bold">1. Pilih Transaksi Sewa</label>
                            <select name="transaksi_sewa_id" class="form-select border-primary" onchange="this.form.submit()">
                                <option value="">-- Pilih Transaksi Aktif --</option>
                                @foreach ($transaksi as $row)
                                    <option value="{{ $row->id }}" {{ request('transaksi_sewa_id') == $row->id ? 'selected' : '' }}>
                                        {{ $row->pelanggan->nama ?? '-' }} | [{{ $row->alat->kode_unit ?? '-' }}] {{ $row->alat->nama_alat ?? '-' }} | Lokasi: {{ $row->lokasi_proyek ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Form input nominal dan struk transfer akan muncul setelah transaksi dipilih.</small>
                        </div>
                    </form>

                    @if (request()->filled('transaksi_sewa_id'))
                        <hr class="mb-4">
                        <form action="{{ route('dp.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="transaksi_sewa_id" value="{{ old('transaksi_sewa_id', request('transaksi_sewa_id')) }}">

                            <div class="p-3 bg-light rounded border mb-3">
                                <label class="form-label fw-bold mb-3 d-block border-bottom pb-2">2. Detail Pembayaran</label>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tanggal Pembayaran <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i data-lucide="calendar" class="icon-sm"></i></span>
                                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-success fw-bold">Jumlah Bayar (Rp) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text border-success bg-success-subtle text-success">Rp</span>
                                            <input type="number" name="jumlah" class="form-control border-success @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" required placeholder="Contoh: 5000000">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                            <option value="belum_lunas" {{ old('status') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas (DP / Cicilan)</option>
                                            <option value="lunas" {{ old('status') == 'lunas' ? 'selected' : '' }}>Lunas (Pelunasan)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Upload Bukti Transfer <span class="text-danger">*</span></label>
                                        <input type="file" name="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror" accept="image/*" required>
                                        <div class="form-text text-muted small">Upload struk/nota (JPG, PNG). Maks 2MB.</div>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Keterangan Tambahan</label>
                                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="2" placeholder="Contoh: DP Awal Proyek Tol">{{ old('keterangan') }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('dp.index') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary text-white">
                                    <i data-lucide="save" class="icon-sm me-1"></i> Simpan Pembayaran
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection