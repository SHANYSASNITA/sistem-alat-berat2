@extends('admin.layout')

@section('content')

{{-- Breadcrumb navigasi atas --}}
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
                
                {{-- Header tabel & tombol tambah --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="card-title mb-0">Daftar Alat Berat</h6>
                    <a href="{{ route('alat.create') }}" class="btn btn-primary btn-icon-text">
                        <i class="btn-icon-prepend" data-lucide="plus"></i>
                        Tambah Alat
                    </a>
                </div>
                
                <p class="text-secondary mb-4">Manajemen seluruh unit armada alat berat yang tersedia di C.V. LISAN.</p>
                
                {{-- Tabel Data --}}
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
                                <th>Foto</th>
                                <th>Status</th>
                                <th width="150px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Looping data alat dari database --}}
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $row->kode_unit }}</span></td>
                                    <td class="fw-bold">{{ $row->nama_alat }}</td>
                                    <td>{{ $row->jenis }}</td>
                                    <td>{{ $row->merk }}</td>
                                    <td>{{ $row->tahun }}</td>
                                    
                                    {{-- Kolom foto dengan fitur klik perbesar --}}
                                    <td class="text-center">
                                        @if($row->foto)
                                            <a href="javascript:void(0);" onclick="showImageModal('{{ asset('storage/' . $row->foto) }}', '{{ $row->nama_alat }}')">
                                                <img src="{{ asset('storage/' . $row->foto) }}" 
                                                     alt="Foto {{ $row->nama_alat }}" 
                                                     class="rounded border shadow-sm" 
                                                     style="width: 70px; height: 50px; object-fit: cover;"
                                                     data-bs-toggle="tooltip" title="Klik untuk lihat gambar">
                                            </a>
                                        @else
                                            <span class="text-muted small">No Photo</span>
                                        @endif
                                    </td>
                                    
                                    {{-- Kolom status pakai warna badge beda-beda --}}
                                    <td>
                                        @if ($row->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif ($row->status == 'maintenance')
                                            <span class="badge bg-warning text-dark">Maintenance</span>
                                        @else
                                            <span class="badge bg-danger">Broken</span>
                                        @endif
                                    </td> {{-- MISSING TAG FIXED HERE --}}
                                    
                                    {{-- Tombol Edit & Hapus --}}
                                    <td class="text-center">
                                        <a href="{{ route('alat.edit', $row->id) }}" class="btn btn-outline-warning btn-icon btn-sm" data-bs-toggle="tooltip" title="Edit">
                                            <i data-lucide="edit-2" width="16" height="16"></i>
                                        </a>

                                        <form action="{{ route('alat.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alat berat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-icon btn-sm" data-bs-toggle="tooltip" title="Hapus">
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

{{-- Modal buat nampilin foto ukuran besar --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="imageModalLabel">Preview Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="previewImage" src="" alt="Preview" class="img-fluid w-100" style="max-height: 80vh; object-fit: contain; background-color: #f8f9fa;">
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            // Setup DataTable
            if ($('#dataTableExample').length) {
                $('#dataTableExample').DataTable({
                    "order": [],
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

        // Fungsi trigger buka modal foto
        function showImageModal(imageUrl, alatName) {
            $('#previewImage').attr('src', imageUrl);
            $('#imageModalLabel').text('Foto: ' + alatName);
            $('#imagePreviewModal').modal('show');
        }
    </script>
@endpush