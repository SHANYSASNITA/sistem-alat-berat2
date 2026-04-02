@extends('admin.layout')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data HM Log</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="card-title mb-0">Log Hour Meter (HM) Mesin</h6>
                    <a href="{{ route('hm.create') }}" class="btn btn-primary btn-icon-text">
                        <i class="btn-icon-prepend" data-lucide="plus"></i>
                        Tambah Log HM
                    </a>
                </div>
                
                <p class="text-secondary mb-4">Catatan pemakaian Hour Meter mesin untuk setiap unit alat berat.</p>
                
                <div class="table-responsive">
                    <table id="dataTableHM" class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Informasi Transaksi</th>
                                <th>HM Terakhir</th>
                                <th>HM Sekarang</th>
                                <th>Total Pakai</th>
                                <th width="120px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="fw-bold d-block">{{ $row->transaksi->pelanggan->nama ?? '-' }}</span>
                                        <small class="text-muted text-uppercase">{{ $row->transaksi->alat->nama_alat ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium">{{ number_format($row->hm_terkahir, 1) }}</span>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($row->tanggal_terakhir)->format('d/m/y') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column text-primary">
                                            <span class="fw-bold">{{ number_format($row->hm_sekarang, 1) }}</span>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($row->tanggal_sekarang)->format('d/m/y') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success">
                                            +{{ number_format($row->hm_sekarang - $row->hm_terkahir, 1) }} Jam
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('hm.edit', $row->id) }}" class="btn btn-outline-warning btn-icon btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                <i data-lucide="edit-2" width="14" height="14"></i>
                                            </a>
                                            <form action="{{ route('hm.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus catatan HM log ini?')">
                                                @csrf @method('DELETE')
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
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            if ($('#dataTableHM').length) {
                $('#dataTableHM').DataTable({
                    "aLengthMenu": [[10, 30, 50, -1], [10, 30, 50, "All"]],
                    "iDisplayLength": 10,
                    "language": { search: "", searchPlaceholder: "Cari data HM..." }
                });
            }
        });
    </script>
@endpush