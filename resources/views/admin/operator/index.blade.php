@extends('admin.layout')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Operator</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="card-title mb-0">Daftar Operator</h6>
                    <a href="{{ route('operator.create') }}" class="btn btn-primary btn-icon-text">
                        <i class="btn-icon-prepend" data-lucide="plus"></i>
                        Tambah Operator
                    </a>
                </div>
                
                <p class="text-secondary mb-4">Manajemen data operator alat berat C.V. LISAN.</p>
                
                <div class="table-responsive">
                    <table id="dataTableOperator" class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Operator</th>
            <th>Kontak</th> <th>Alamat</th>
            <th>Tanggal Lahir </th>
            <th>Foto Kartu Identitas</th>
            <th width="150px" class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="fw-bold">{{ $row->nama }}</td>
                <td>{{ $row->no_hp ?? '-' }}</td>
                <td>{{ Str::limit($row->alamat, 50, '...') ?? '-' }}</td>
                <td>{{ $row->tanggal_lahir ?? '-' }}</td>
                
                <td>
                    @if($row->ktp_operator)
                        <a href="javascript:void(0);" onclick="showImageModal('{{ asset('storage/' . $row->ktp_operator) }}', 'KTP {{ $row->nama }}')">
                            <img src="{{ asset('storage/' . $row->ktp_operator) }}" 
                                alt="KTP {{ $row->nama }}" 
                                style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;"
                                data-bs-toggle="tooltip" title="Klik untuk lihat gambar">
                        </a>
                    @else
                        <span class="text-muted small"><i data-lucide="image-off" class="w-4 h-4 d-inline"></i> Kosong</span>
                    @endif
                </td>

                <td class="text-center">
                    <a href="{{ route('operator.edit', $row->id) }}" class="btn btn-outline-warning btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                        <i data-lucide="edit-2" width="16" height="16"></i>
                    </a>

                    <form action="{{ route('operator.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data operator ini?')">
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

<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="imageModalLabel">Preview Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                {{-- Tag img ini awalnya kosong, src-nya akan diisi otomatis oleh Javascript --}}
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
            if ($('#dataTableOperator').length) {
                $('#dataTableOperator').DataTable({
                    "order": [],
                    "aLengthMenu": [
                        [5, 10, 30, 50, -1],
                        [5, 10, 30, 50, "All"]
                    ],
                    "iDisplayLength": 10, // Secara default menampilkan 10 data
                    "language": {
                        search: "",
                        searchPlaceholder: "Cari operator..."
                    }
                });
            }
        });
        // Fungsi untuk menampilkan pop up gambar
    function showImageModal(imageUrl, alatName) {
        // 1. Masukkan link gambar ke dalam Pop-Up
        $('#previewImage').attr('src', imageUrl);
        
        // 2. Ubah judul Pop-Up sesuai nama alat
        $('#imageModalLabel').text('Foto: ' + alatName);
        
        // 3. Tampilkan Pop-Up nya
        $('#imagePreviewModal').modal('show');
    }
    </script>
@endpush