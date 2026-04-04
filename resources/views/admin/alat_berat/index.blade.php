@extends('admin.layout')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Master Alat Berat</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="card-title mb-0">Daftar Alat Berat</h6>
                    <a href="{{ route('alat.create') }}" class="btn btn-primary btn-icon-text">
                        <i class="btn-icon-prepend" data-lucide="plus"></i>
                        Tambah Alat
                    </a>
                </div>
                
                <p class="text-secondary mb-4">Manajemen seluruh unit armada alat berat yang tersedia di C.V. LISAN.</p>
                
                <div class="table-responsive">
                    <table id="dataTableExample" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Unit</th>
                                <th>Nama Alat</th>
                                <th>Jenis</th>
                                <th>Merk</th>
                                <th>Tahun</th>
                                <th>foto</th>
                                <th>Status</th>
                                <th width="150px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $row->kode_unit }}</span></td>
                                    <td class="fw-bold">{{ $row->nama_alat }}</td>
                                    <td>{{ $row->jenis }}</td>
                                    <td>{{ $row->merk }}</td>
                                    <td>{{ $row->tahun }}</td>
                                    
                                    <td class="text-center">
                                        @if($row->foto)
                                            <a href="{{ asset('storage/' . $row->foto) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $row->foto) }}" 
                                                    alt="Foto {{ $row->nama_alat }}" 
                                                    class="rounded border shadow-sm" 
                                                    style="width: 70px; height: 50px; object-fit: cover;">
                                            </a>
                                        @else
                                            <span class="text-muted small">No Photo</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        @if ($row->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif ($row->status == 'maintenance')
                                            <span class="badge bg-warning text-dark">Maintenance</span>
                                        @else
                                            <span class="badge bg-danger">Broken</span>
                                        @endif
                                    <td class="text-center">
                                        <a href="{{ route('alat.edit', $row->id) }}" class="btn btn-outline-warning btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i data-lucide="edit-2" width="16" height="16"></i>
                                        </a>

                                        <form action="{{ route('alat.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alat berat ini?')">
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
        // Gunakan fungsi jQuery standar
        $(document).ready(function() {
            if ($('#dataTableExample').length) {
                $('#dataTableExample').DataTable({
                    "aLengthMenu": [
                        [5, 10, 30, 50, -1],
                        [5, 10, 30, 50, "All"]
                    ],
                    "iDisplayLength": 5,
                    "language": {
                        search: "",
                        searchPlaceholder: "Cari data..."
                    }
                });
            }
        });
    </script>
@endpush