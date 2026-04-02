@extends('admin.layout')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Lokasi Proyek</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="card-title mb-0">Daftar Lokasi Proyek</h6>
                    <a href="{{ route('lokasi.create') }}" class="btn btn-primary btn-icon-text">
                        <i class="btn-icon-prepend" data-lucide="plus"></i>
                        Tambah Lokasi
                    </a>
                </div>
                
                <p class="text-secondary mb-4">Manajemen data lokasi proyek penyewaan alat berat.</p>
                
                <div class="table-responsive">
                    <table id="dataTableLokasi" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Lokasi</th>
                                <th>Kabupaten</th>
                                <th>Alamat</th>
                                <th width="150px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $row->nama_lokasi }}</td>
                                    <td>
                                        @if($row->kabupaten)
                                            <span class="badge bg-warning">{{ $row->kabupaten }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($row->alamat, 50, '...') ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('lokasi.edit', $row->id) }}" class="btn btn-outline-warning btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i data-lucide="edit-2" width="16" height="16"></i>
                                        </a>

                                        <form action="{{ route('lokasi.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data lokasi proyek ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                <i data-lucide="trash" width="16" height="16"></i>
                                            </button>
                                        </form>
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
            if ($('#dataTableLokasi').length) {
                $('#dataTableLokasi').DataTable({
                    "aLengthMenu": [
                        [5, 10, 30, 50, -1],
                        [5, 10, 30, 50, "All"]
                    ],
                    "iDisplayLength": 10,
                    "language": {
                        search: "",
                        searchPlaceholder: "Cari lokasi..."
                    }
                });
            }
        });
    </script>
@endpush