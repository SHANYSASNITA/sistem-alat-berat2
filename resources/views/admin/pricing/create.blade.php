@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pricing.index') }}">Data Pricing Alat</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pricing</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Form Tambah Harga Sewa (Pricing)</h6>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal menyimpan data!</strong> Silakan periksa kembali isian form di bawah.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('pricing.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alat Berat <span class="text-danger">*</span></label>
                                <select name="alat_berat_id" class="form-select @error('alat_berat_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Alat Berat --</option>
                                    @foreach ($alat as $row)
                                        <option value="{{ $row->id }}" {{ old('alat_berat_id') == $row->id ? 'selected' : '' }}>
                                            {{ $row->kode_unit }} | {{ $row->nama_alat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('alat_berat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('status') == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                                    <option value="ready" {{ old('status') == 'ready' ? 'selected' : '' }}>Ready (Siap Sewa)</option>
                                    <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>In Use (Sedang Beroperasi)</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance (Perbaikan)</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3 mt-2">
                                <label class="form-label fw-bold">Layanan & Tarif (Centang yang tersedia) <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card border border-light shadow-sm bg-light">
                                            <div class="card-body p-3">
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" name="layanan_baket" id="checkBaket" value="1" {{ old('layanan_baket') ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold" for="checkBaket">Layanan Baket</label>
                                                </div>
                                                <label class="form-label small text-muted">Tarif Baket (Per Jam)</label>
                                                <input type="number" name="harga_baket" class="form-control @error('harga_baket') is-invalid @enderror" value="{{ old('harga_baket') }}" placeholder="Contoh: 150000">
                                                @error('harga_baket') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card border border-light shadow-sm bg-light">
                                            <div class="card-body p-3">
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" name="layanan_breker" id="checkBreker" value="1" {{ old('layanan_breker') ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold" for="checkBreker">Layanan Breker</label>
                                                </div>
                                                <label class="form-label small text-muted">Tarif Breker (Per Jam)</label>
                                                <input type="number" name="harga_breker" class="form-control @error('harga_breker') is-invalid @enderror" value="{{ old('harga_breker') }}" placeholder="Contoh: 200000">
                                                @error('harga_breker') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Berlaku Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="berlaku_mulai" class="form-control @error('berlaku_mulai') is-invalid @enderror" value="{{ old('berlaku_mulai') }}" required>
                                @error('berlaku_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Berlaku Selesai</label>
                                <input type="date" name="berlaku_selesai" class="form-control @error('berlaku_selesai') is-invalid @enderror" value="{{ old('berlaku_selesai') }}">
                                <small class="text-muted">Kosongkan jika harga ini berlaku seterusnya.</small>
                                @error('berlaku_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('pricing.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i data-lucide="save" class="icon-sm me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection