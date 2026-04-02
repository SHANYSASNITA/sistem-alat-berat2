@extends('admin.layout')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Timesheet</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <h6 class="card-title mb-0">Laporan Penggunaan Alat (Timesheet)</h6>
                    
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('timesheet.create') }}" class="btn btn-primary btn-icon-text btn-sm">
                            <i class="btn-icon-prepend" data-lucide="plus"></i> Tambah Data
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="dataTableTimesheet" class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Informasi Transaksi</th>
                                <th>Tanggal</th>
                                <th>Lokasi Proyek</th>
                                <th class="text-center">HM Awal</th>
                                <th class="text-center">HM Akhir</th>
                                <th width="100px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="fw-bold d-block text-primary mb-1">
                                            {{ $row->transaksi->pelanggan->nama ?? '-' }}
                                        </span>
                                        
                                        <small class="text-muted d-block mb-1" style="font-size: 0.80rem;">
                                            [{{ $row->transaksi->alat->kode_unit ?? '-' }}]
                                        </small>
                                        
                                        <small class="text-muted d-block" style="font-size: 0.80rem;">
                                            {{ $row->transaksi->alat->nama_alat ?? '-' }} | Opr: {{ $row->transaksi->operator->nama ?? '-' }}
                                        </small>
                                    </td>
                        
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i data-lucide="calendar" class="text-secondary me-2" width="14" height="14"></i>
                                            {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                                        </div>
                                    </td>
                                    
                                    <td>{{ $row->transaksi->lokasi_proyek ?? '-' }}</td>
                                    <td class="text-center fw-bold text-secondary">{{ $row->hm_awal ?? '0' }}</td>
                                    <td class="text-center fw-bold text-primary">{{ $row->hm_akhir ?? '0' }}</td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                             <a href="{{ route('timesheet.show', $row->id) }}" class="btn btn-outline-info btn-icon btn-sm" data-bs-toggle="tooltip" title="Detail">
                                                <i data-lucide="eye" width="14" height="14"></i>
                                            </a>   
                                             <a href="{{ route('timesheet.edit', $row->id) }}" class="btn btn-outline-warning btn-icon btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                <i data-lucide="edit" width="14" height="14"></i>
                                            </a>
                                            <form action="{{ route('timesheet.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus log timesheet ini?')">
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
            if ($('#dataTableTimesheet').length) {
                $('#dataTableTimesheet').DataTable({
                    "aLengthMenu": [[10, 30, 50, -1], [10, 30, 50, "All"]],
                    "iDisplayLength": 10,
                    "language": { search: "", searchPlaceholder: "Cari data..." }
                });
            }
            
            // Logic Export
            document.getElementById('exportForm').addEventListener('submit', function(e) {
                const transaksiId = document.getElementById('transaksiSelect').value;
                if (!transaksiId) {
                    alert('Pilih transaksi yang ingin di-export terlebih dahulu.');
                    e.preventDefault();
                    return;
                }
                this.action = this.action.replace('dummy', transaksiId);
            });
        });
    </script>
@endpush