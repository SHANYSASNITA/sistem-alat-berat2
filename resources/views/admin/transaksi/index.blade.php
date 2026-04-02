@extends('admin.layout')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Transaksi Sewa</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="card-title mb-0">Daftar Transaksi Sewa</h6>
                    <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-icon-text">
                        <i class="btn-icon-prepend" data-lucide="plus"></i>
                        Buat Transaksi Baru
                    </a>
                </div>
                
                <p class="text-secondary mb-4">Manajemen seluruh aktivitas penyewaan alat berat C.V. LISAN.</p>
                
                <div class="table-responsive">
                    <table id="dataTableTransaksi" class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pelanggan</th>
                                <th>Alat & Operator</th>
                                <th>Periode Sewa</th>
                                <th>Lokasi Proyek</th>
                                <th>Hrg Baket</th>
                                <th>Hrg Breker</th>
                                <th>Status</th>
                                <th width="100px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-primary">{{ $row->pelanggan->nama ?? '-' }}</td>
                                    <td>
                                        <span class="fw-bold d-block">{{ $row->alat->kode_unit ?? '-' }}</span>
                                        <small class="text-secondary">Alat: {{ $row->alat->nama_alat ?? '-'}} || Opr: {{ $row->operator->nama ?? '-'}}</small>
                                    </td>
                                    <td>
                                        <span style="font-size: 0.80rem;">
                                            {{ \Carbon\Carbon::parse($row->tanggal_mulai)->format('d M y') }} -
                                            {{ $row->tanggal_selesai ? \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M y') : 'Berjalan' }}
                                        </span>
                                    </td>
                                    <td>{{ $row->lokasi_proyek }}</td>
                                    <td>Rp {{ number_format($row->harga_sewa_baket, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($row->harga_sewa_breker, 0, ',', '.') }}</td>

                                    <td>
                                        @if ($row->status == 'berjalan')
                                            <span class="badge bg-warning text-dark">Berjalan</span>
                                        @elseif($row->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Batal</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('transaksi.edit', $row->id) }}" class="btn btn-outline-warning btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i data-lucide="edit-2" width="16" height="16"></i>
                                            </a>

                                            <form action="{{ route('transaksi.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus transaksi ini? Tindakan ini tidak bisa dibatalkan.')">
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
            if ($('#dataTableTransaksi').length) {
                $('#dataTableTransaksi').DataTable({
                    "aLengthMenu": [
                        [5, 10, 30, 50, -1],
                        [5, 10, 30, 50, "All"]
                    ],
                    "iDisplayLength": 10,
                    "language": {
                        search: "",
                        searchPlaceholder: "Cari transaksi..."
                    }
                });
            }
        });
    </script>
@endpush