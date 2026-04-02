@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi Sewa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Transaksi</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card border-top border-4 border-warning">
                <div class="card-body">
                    <h6 class="card-title mb-4">Edit Formulir Penyewaan</h6>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal memperbarui data!</strong> Silakan periksa kembali isian form di bawah.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('transaksi.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row border-bottom pb-4 mb-4">
                            <h6 class="text-primary mb-3"><i data-lucide="info" class="icon-sm me-1"></i> Informasi Entitas</h6>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pelanggan <span class="text-danger">*</span></label>
                                <select name="pelanggan_id" class="form-select @error('pelanggan_id') is-invalid @enderror" required>
                                    @foreach ($pelanggan as $item)
                                        <option value="{{ $item->id }}" {{ old('pelanggan_id', $data->pelanggan_id) == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Alat Berat <span class="text-danger">*</span></label>
                                <select name="alat_berat_id" class="form-select @error('alat_berat_id') is-invalid @enderror" required>
                                    @foreach ($alat as $item)
                                        <option value="{{ $item->id }}" {{ old('alat_berat_id', $data->alat_berat_id) == $item->id ? 'selected' : '' }}>{{ $item->nama_alat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Operator <span class="text-danger">*</span></label>
                                <select name="operator_id" class="form-select @error('operator_id') is-invalid @enderror" required>
                                    @foreach ($operator as $item)
                                        <option value="{{ $item->id }}" {{ old('operator_id', $data->operator_id) == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row border-bottom pb-4 mb-4">
                            <h6 class="text-primary mb-3"><i data-lucide="map-pin" class="icon-sm me-1"></i> Detail Pekerjaan & Lokasi</h6>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Sewa <span class="text-danger">*</span></label>
                                <input type="text" name="jenis_sewa" class="form-control" value="{{ old('jenis_sewa', $data->jenis_sewa) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi Proyek <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi_proyek" class="form-control" value="{{ old('lokasi_proyek', $data->lokasi_proyek) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Titik Mobilisasi <span class="text-danger">*</span></label>
                                <input type="text" name="mobilisasi" class="form-control" value="{{ old('mobilisasi', $data->mobilisasi) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Titik Demobilisasi <span class="text-danger">*</span></label>
                                <input type="text" name="demobilisasi" class="form-control" value="{{ old('demobilisasi', $data->demobilisasi) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label d-block">Jenis Pekerjaan</label>
                                @php
                                    // Decode json/array jika formatnya string dari database
                                    $pekerjaanArray = is_string($data->jenis_pekerjaan) ? json_decode($data->jenis_pekerjaan, true) : ($data->jenis_pekerjaan ?? []);
                                @endphp
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]" value="baket" id="baket" {{ in_array('baket', $pekerjaanArray) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="baket">Baket</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]" value="breker" id="breker" {{ in_array('breker', $pekerjaanArray) ? 'checked' : '' }}>
                                    <label class="form-check-label text-warning fw-bold" for="breker">Breker</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <h6 class="text-primary mb-3"><i data-lucide="dollar-sign" class="icon-sm me-1"></i> Biaya & Jadwal</h6>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Biaya Modem (Rp)</label>
                                <input type="number" name="biaya_modem" class="form-control" value="{{ old('biaya_modem', $data->biaya_modem) }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Harga Sewa Baket (Rp)</label>
                                <input type="number" name="harga_sewa_baket" class="form-control" value="{{ old('harga_sewa_baket', $data->harga_sewa_baket) }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Harga Sewa Breker (Rp)</label>
                                <input type="number" name="harga_sewa_breker" class="form-control" value="{{ old('harga_sewa_breker', $data->harga_sewa_breker) }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="berjalan" {{ old('status', $data->status) == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                                    <option value="selesai" {{ old('status', $data->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="batal" {{ old('status', $data->status) == 'batal' ? 'selected' : '' }}>Batal</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', is_string($data->tanggal_mulai) ? \Carbon\Carbon::parse($data->tanggal_mulai)->format('Y-m-d') : ($data->tanggal_mulai ? $data->tanggal_mulai->format('Y-m-d') : '')) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $data->tanggal_selesai ? (is_string($data->tanggal_selesai) ? \Carbon\Carbon::parse($data->tanggal_selesai)->format('Y-m-d') : $data->tanggal_selesai->format('Y-m-d')) : '') }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i data-lucide="save" class="icon-sm me-1"></i> Update Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection