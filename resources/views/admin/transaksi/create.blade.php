@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi Sewa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Transaksi</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card border-top border-4 border-primary">
                <div class="card-body">
                    <h6 class="card-title mb-4">Formulir Penyewaan Baru</h6>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal menyimpan data!</strong> Silakan periksa kembali isian form di bawah.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('transaksi.store') }}" method="POST">
                        @csrf

                        <div class="row border-bottom pb-4 mb-4">
                            <h6 class="text-primary mb-3"><i data-lucide="info" class="icon-sm me-1"></i> Informasi Entitas</h6>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pelanggan <span class="text-danger">*</span></label>
                                <select name="pelanggan_id" class="form-select @error('pelanggan_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Pelanggan --</option>
                                    @foreach ($pelanggan as $item)
                                        <option value="{{ $item->id }}" {{ old('pelanggan_id') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Alat Berat <span class="text-danger">*</span></label>
                                <select name="alat_berat_id" class="form-select @error('alat_berat_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Alat --</option>
                                    @foreach ($alat as $item)
                                        <option value="{{ $item->id }}" {{ old('alat_berat_id') == $item->id ? 'selected' : '' }}>
                                            [{{ $item->kode_unit }}] - {{ $item->nama_alat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Operator <span class="text-danger">*</span></label>
                                <select name="operator_id" class="form-select @error('operator_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Operator --</option>
                                    @foreach ($operator as $item)
                                        <option value="{{ $item->id }}" {{ old('operator_id') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row border-bottom pb-4 mb-4">
                            <h6 class="text-primary mb-3"><i data-lucide="map-pin" class="icon-sm me-1"></i> Detail Pekerjaan & Lokasi</h6>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Sewa <span class="text-danger">*</span></label>
                                <input type="text" name="jenis_sewa" class="form-control" value="{{ old('jenis_sewa') }}" required placeholder="Contoh: Sewa Harian/Bulanan">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi Proyek <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi_proyek" class="form-control" value="{{ old('lokasi_proyek') }}" required placeholder="Contoh: Proyek Tol XYZ">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Titik Mobilisasi <span class="text-danger">*</span></label>
                                <input type="text" name="mobilisasi" class="form-control" value="{{ old('mobilisasi') }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Titik Demobilisasi <span class="text-danger">*</span></label>
                                <input type="text" name="demobilisasi" class="form-control" value="{{ old('demobilisasi') }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label d-block">Jenis Pekerjaan</label>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]" value="baket" id="baket" {{ is_array(old('jenis_pekerjaan')) && in_array('baket', old('jenis_pekerjaan')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="baket">Baket</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]" value="breker" id="breker" {{ is_array(old('jenis_pekerjaan')) && in_array('breker', old('jenis_pekerjaan')) ? 'checked' : '' }}>
                                    <label class="form-check-label text-warning fw-bold" for="breker">Breker</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <h6 class="text-primary mb-3"><i data-lucide="dollar-sign" class="icon-sm me-1"></i> Biaya & Jadwal</h6>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Biaya Modem (Rp)</label>
                                <input type="number" name="biaya_modem" class="form-control" value="{{ old('biaya_modem') }}" placeholder="0">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Harga Sewa Baket (Rp)</label>
                                <input type="number" name="harga_sewa_baket" class="form-control" value="{{ old('harga_sewa_baket') }}" placeholder="0">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Harga Sewa Breker (Rp)</label>
                                <input type="number" name="harga_sewa_breker" class="form-control" value="{{ old('harga_sewa_breker') }}" placeholder="0">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="berjalan" {{ old('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="batal" {{ old('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i data-lucide="save" class="icon-sm me-1"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection