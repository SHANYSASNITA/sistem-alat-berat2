@extends('admin.layout')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dp.index') }}">Data Pembayaran</a></li>
        <li class="breadcrumb-item active" aria-current="page">Rincian Pembayaran</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="card-title mb-0">Rincian Riwayat Pembayaran Sewa</h6>
                    <a href="{{ route('dp.create', ['transaksi_sewa_id' => $dp->transaksi_sewa_id]) }}" class="btn btn-primary btn-icon-text btn-sm">
                        <i class="btn-icon-prepend" data-lucide="plus"></i>
                        Tambah Cicilan/Pembayaran
                    </a>
                </div>

                <div class="bg-light p-4 rounded border mb-4">
                    <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">
                        <i data-lucide="file-text" class="icon-sm me-1"></i> Informasi Transaksi
                    </h6>
                    <div class="row">
                        <div class="col-sm-6 col-md-3 mb-3 mb-md-0">
                            <span class="text-muted d-block small mb-1">Nama Pelanggan</span>
                            <span class="fw-bold text-dark fs-6">{{ $dp->transaksi->pelanggan->nama ?? '-' }}</span>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3 mb-md-0">
                            <span class="text-muted d-block small mb-1">Alat Berat & Kode</span>
                            <span class="fw-bold text-dark fs-6">[{{ $dp->transaksi->alat->kode_unit ?? '-' }}] {{ $dp->transaksi->alat->nama_alat ?? '-' }}</span>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3 mb-md-0">
                            <span class="text-muted d-block small mb-1">Operator Bertugas</span>
                            <span class="fw-bold text-dark fs-6">{{ $dp->transaksi->operator->nama ?? '-' }}</span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <span class="text-muted d-block small mb-1">Lokasi Proyek</span>
                            <span class="fw-bold text-dark fs-6">{{ $dp->transaksi->lokasi_proyek ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                <h6 class="card-title mb-3">Tabel Riwayat Transfer/Cicilan</h6>
                <div class="table-responsive">
                    <table id="dataTableDP" class="table table-hover align-middle table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="50px">#</th>
                                <th>Tanggal Bayar</th>
                                <th>Jumlah (Rp)</th>
                                <th>Keterangan</th>
                                <th class="text-center">Bukti Pembayaran</th> 
                                <th width="120px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    
                                    <td data-sort="{{ \Carbon\Carbon::parse($row->tanggal)->format('Y-m-d') }}">
                                        <div class="d-flex align-items-center">
                                            <i data-lucide="calendar" class="text-secondary me-2" width="14" height="14"></i>
                                            <span class="fw-medium">{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    
                                    <td class="fw-bold text-success fs-6">
                                        Rp {{ number_format($row->jumlah, 0, ',', '.') }}
                                    </td>
                                    
                                    <td>
                                        <small class="text-secondary">{{ $row->keterangan ?? '-' }}</small>
                                    </td>

                                    <td class="text-center">
                                        @if($row->bukti_pembayaran)
                                            <a href="{{ asset('storage/' . $row->bukti_pembayaran) }}" target="_blank" data-bs-toggle="tooltip" title="Klik untuk memperbesar">
                                                <img src="{{ asset('storage/' . $row->bukti_pembayaran) }}" 
                                                     alt="Bukti Transfer" 
                                                     class="rounded border"
                                                     style="width: 70px; height: 50px; object-fit: cover; transition: transform 0.2s;">
                                            </a>
                                        @else
                                            <span class="text-muted small"><i data-lucide="image-off" class="w-4 h-4 d-inline me-1"></i> Kosong</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('dp.edit', $row->id) }}" class="btn btn-outline-warning btn-icon btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                <i data-lucide="edit-2" width="14" height="14"></i>
                                            </a>

                                            <form action="{{ route('dp.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus riwayat DP ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-icon btn-sm" data-bs-toggle="tooltip" title="Hapus">
                                                    <i data-lucide="trash" width="14" height="14"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <a href="{{ route('dp.index') }}" class="btn btn-secondary btn-icon-text">
                        <i class="btn-icon-prepend" data-lucide="arrow-left"></i> Kembali ke Buku Induk
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        /* Efek hover pada gambar struk */
        td img:hover {
            transform: scale(1.1);
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            if ($('#dataTableDP').length) {
                $('#dataTableDP').DataTable({
                    "order": [], // Agar urutan 'asc' dari controller tidak dirusak
                    "aLengthMenu": [[10, 30, 50, -1], [10, 30, 50, "All"]],
                    "iDisplayLength": 10,
                    "language": {
                        search: "",
                        searchPlaceholder: "Cari nominal/keterangan..."
                    }
                });
            }
        });
    </script>
@endpush