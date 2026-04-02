@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('operator.index') }}">Data Operator</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Operator</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8 mx-auto stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Form Edit Operator</h6>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal memperbarui data!</strong> Silakan periksa kembali isian form di bawah.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('operator.update', $data->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nama Operator <span class="text-danger">*</span></label>
        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $data->nama) }}" required>
        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">No Telepon</label>
        <input type="number" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $data->no_hp) }}">
        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-4">
        <label class="form-label">Alamat Lengkap</label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $data->alamat) }}</textarea>
        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $data->tanggal_lahir) }}" required>
        @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    
    <div class="mb-4">
        <label class="form-label d-block">KTP Operator</label>
        
        @if($data->ktp_operator)
            <div class="mb-3">
                <p class="text-muted small mb-2">KTP Saat Ini:</p>
                <img src="{{ asset('storage/' . $data->ktp_operator) }}" alt="KTP" class="img-thumbnail" style="height: 120px; object-fit: cover;">
            </div>
        @endif

        <label class="form-label">Ganti Foto KTP <span class="text-muted small">(Opsional)</span></label>
        <input type="file" name="ktp_operator" class="form-control @error('ktp_operator') is-invalid @enderror" accept="image/*">
        <div class="form-text text-muted small">Biarkan kosong jika tidak ingin mengubah foto KTP.</div>
        @error('ktp_operator') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('operator.index') }}" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-warning text-dark">
            <i data-lucide="edit-2" class="icon-sm me-1"></i> Perbarui Data
        </button>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>
@endsection