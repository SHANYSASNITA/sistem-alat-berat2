@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('lokasi.index') }}">Data Lokasi Proyek</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Lokasi</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8 mx-auto stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Form Edit Lokasi Proyek</h6>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal memperbarui data!</strong> Silakan periksa kembali isian form di bawah.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('lokasi.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lokasi" class="form-control @error('nama_lokasi') is-invalid @enderror" value="{{ old('nama_lokasi', $data->nama_lokasi) }}" required>
                            @error('nama_lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control @error('kabupaten') is-invalid @enderror" value="{{ old('kabupaten', $data->kabupaten) }}">
                            @error('kabupaten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Alamat Detail</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="4">{{ old('alamat', $data->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('lokasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i data-lucide="save" class="icon-sm me-1"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection