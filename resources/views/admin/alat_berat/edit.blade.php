@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('alat.index') }}">Data Alat Berat</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Form Edit Alat Berat</h6>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal memperbarui data!</strong> Silakan periksa kembali isian form di bawah.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('alat.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Unit <span class="text-danger">*</span></label>
                                <input type="text" name="kode_unit" class="form-control @error('kode_unit') is-invalid @enderror" value="{{ old('kode_unit', $data->kode_unit) }}" required>
                                @error('kode_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Alat <span class="text-danger">*</span></label>
                                <input type="text" name="nama_alat" class="form-control @error('nama_alat') is-invalid @enderror" value="{{ old('nama_alat', $data->nama_alat) }}" required>
                                @error('nama_alat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis <span class="text-danger">*</span></label>
                                <input type="text" name="jenis" class="form-control @error('jenis') is-invalid @enderror" value="{{ old('jenis', $data->jenis) }}" required>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Merk</label>
                                <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" value="{{ old('merk', $data->merk) }}">
                                @error('merk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', $data->tahun) }}">
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ old('status', $data->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="maintenance" {{ old('status', $data->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="broken" {{ old('status', $data->status) == 'broken' ? 'selected' : '' }}>Broken</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary me-2 mt-3 text-white">
                            <i data-lucide="save" class="icon-sm me-1"></i> Update Data
                        </button>
                        <a href="{{ route('alat.index') }}" class="btn btn-secondary mt-3">Kembali</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection