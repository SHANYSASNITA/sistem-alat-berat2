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
                                            {{ $row->nama_alat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('alat_berat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Pekerjaan <span class="text-danger">*</span></label>
                                <select name="jenis_pekerjaan" class="form-select @error('jenis_pekerjaan') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Jenis Pekerjaan --</option>
                                    <option value="baket" {{ old('jenis_pekerjaan') == 'baket' ? 'selected' : '' }}>Baket</option>
                                    <option value="breker" {{ old('jenis_pekerjaan') == 'breker' ? 'selected' : '' }}>Breker</option>
                                </select>
                                @error('jenis_pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Per Hari (Rp)</label>
                                <input type="number" name="harga_per_hari" class="form-control @error('harga_per_hari') is-invalid @enderror" value="{{ old('harga_per_hari') }}" placeholder="Contoh: 1500000">
                                @error('harga_per_hari') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Per Jam (Rp)</label>
                                <input type="number" name="harga_per_jam" class="form-control @error('harga_per_jam') is-invalid @enderror" value="{{ old('harga_per_jam') }}" placeholder="Contoh: 200000">
                                @error('harga_per_jam') <div class="invalid-feedback">{{ $message }}</div> @enderror
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