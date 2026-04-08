@extends('admin.layout')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Pricing Alat</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="card-title mb-0">Daftar Harga Sewa (Pricing)</h6>
                    <a href="{{ route('pricing.create') }}" class="btn btn-primary btn-icon-text">
                        <i class="btn-icon-prepend" data-lucide="plus"></i>
                        Tambah Pricing
                    </a>
                </div>
                
                <p class="text-secondary mb-4">Manajemen daftar harga sewa alat berat berdasarkan layanan (Baket & Breker).</p>
                
                <div class="table-responsive">
                    <table id="dataTablePricing" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Alat Berat</th>
                                <th>Tarif Baket / Jam</th>
                                <th>Tarif Breker / Jam</th>
                                <th>Masa Berlaku</th>
                                <th>Status</th>
                                <th width="120px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-dark">{{ $row->alat->nama_alat ?? '-' }}</td>
                                    
                                    {{-- Kolom Harga Baket --}}
                                    <td>
                                        @if($row->harga_baket)
                                            <span class="text-success fw-bold">Rp {{ number_format($row->harga_baket, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    
                                    {{-- Kolom Harga Breker --}}
                                    <td>
                                        @if($row->harga_breker)
                                            <span class="text-warning fw-bold">Rp {{ number_format($row->harga_breker, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    
                                    {{-- Kolom Masa Berlaku --}}
                                    <td>
                                        <span class="text-secondary" style="font-size: 0.85rem;">
                                            {{ \Carbon\Carbon::parse($row->berlaku_mulai)->format('d M Y') }} s/d <br>
                                            {{ $row->berlaku_selesai ? \Carbon\Carbon::parse($row->berlaku_selesai)->format('d M Y') : 'Seterusnya' }}
                                        </span>
                                    </td>

                                    {{-- Kolom Status --}}
                                    <td>
                                        @if ($row->status == 'ready')
                                            <span class="badge bg-success">Ready</span>
                                        @elseif ($row->status == 'in_use')
                                            <span class="badge bg-primary">In Use</span>
                                        @elseif ($row->status == 'maintenance')
                                            <span class="badge bg-danger">Maintenance</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('pricing.edit', $row->id) }}" class="btn btn-outline-warning btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i data-lucide="edit-2" width="16" height="16"></i>
                                            </a>

                                            <form action="{{ route('pricing.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pricing ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                    <i data-lucide="trash" width="16" height="16"></i>
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
            if ($('#dataTablePricing').length) {
                $('#dataTablePricing').DataTable({
                    "aLengthMenu": [
                        [5, 10, 30, 50, -1],
                        [5, 10, 30, 50, "All"]
                    ],
                    "iDisplayLength": 10,
                    "language": {
                        search: "",
                        searchPlaceholder: "Cari data..."
                    }
                });
            }
        });
    </script>
@endpush