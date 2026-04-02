@extends('admin.layout')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('timesheet.index') }}">Data Timesheet</a></li>
        <li class="breadcrumb-item active" aria-current="page">Rincian Laporan Transaksi</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <h6 class="card-title mb-0">Rincian Laporan Penggunaan Alat (Timesheet)</h6>
                    
                    <div class="d-flex flex-wrap gap-2">
                        <div class="d-flex gap-1">
                            <div class="input-group input-group-sm">
                                <a href="{{ route('timesheet.export', $timesheet->transaksi_sewa_id) }}" class="btn btn-outline-success">
                                    <i data-lucide="download" class="icon-sm me-1"></i> Export Excel
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('timesheet.create', ['transaksi_id' => $timesheet->transaksi_sewa_id]) }}" class="btn btn-primary btn-icon-text btn-sm">
                            <i class="btn-icon-prepend" data-lucide="plus"></i> Tambah Log Harian
                        </a>
                    </div>
                </div>

                <div class="bg-light p-4 rounded border mb-4">
                    <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">
                        <i data-lucide="info" class="icon-sm me-1"></i> Informasi Transaksi & Proyek
                    </h6>
                    <div class="row">
                        <div class="col-sm-6 col-md-3 mb-3 mb-md-0">
                            <span class="text-muted d-block small mb-1">Nama Pelanggan</span>
                            <span class="fw-bold text-dark fs-6">{{ $timesheet->transaksi->pelanggan->nama ?? '-' }}</span>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3 mb-md-0">
                            <span class="text-muted d-block small mb-1">Alat Berat & Kode</span>
                            <span class="fw-bold text-dark fs-6">[{{ $timesheet->transaksi->alat->kode_unit ?? '-' }}] {{ $timesheet->transaksi->alat->nama_alat ?? '-' }}</span>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3 mb-md-0">
                            <span class="text-muted d-block small mb-1">Operator Bertugas</span>
                            <span class="fw-bold text-dark fs-6">{{ $timesheet->transaksi->operator->nama ?? '-' }}</span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <span class="text-muted d-block small mb-1">Lokasi Proyek</span>
                            <span class="fw-bold text-dark fs-6">{{ $timesheet->transaksi->lokasi_proyek ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <h6 class="card-title mb-3">Tabel Log Aktivitas Harian</h6>
                <div class="table-responsive">
                    <table id="dataTableTimesheetDetail" class="table table-bordered table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th width="50px">No</th>
                                <th>Tanggal</th>
                                <th class="text-center">Jam Baket</th>
                                <th class="text-center">Jam Breker</th>
                                <th class="text-center">Foto</th>
                                <th width="100px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td data-sort="{{ \Carbon\Carbon::parse($row->tanggal)->format('Y-m-d') }}">
                                    <div class="d-flex align-items-center">
                                        <i data-lucide="calendar" class="text-secondary me-2" width="14" height="14"></i>
                                        {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $row->jam_baket > 0 ? 'bg-light text-dark border' : 'text-muted' }}">
                                        {{ $row->jam_baket ?? '0' }} Jam
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $row->jam_breker > 0 ? 'bg-warning text-dark' : 'text-muted' }}">
                                        {{ $row->jam_breker ?? '0' }} Jam
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($row->foto)
                                        <a href="{{ asset('storage/' . $row->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $row->foto) }}" 
                                                class="rounded border"
                                                style="width: 50px; height: 35px; object-fit: cover;">
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('timesheet.edit', ['timesheet' => $row->id, 'from_detail' => 1]) }}" class="btn btn-outline-warning btn-icon btn-sm" data-bs-toggle="tooltip" title="Edit Log">
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

                <div class="mt-4 pt-3 border-top">
                    <a href="{{ route('timesheet.index') }}" class="btn btn-secondary btn-icon-text">
                        <i class="btn-icon-prepend" data-lucide="arrow-left"></i> Kembali ke Daftar Utama
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            if ($('#dataTableTimesheetDetail').length) {
                $('#dataTableTimesheetDetail').DataTable({
                    "order": [], 
                    "language": {
                        search: "",
                        searchPlaceholder: "Cari data log..."
                    }
                });
            }
        });
    </script>
@endpush