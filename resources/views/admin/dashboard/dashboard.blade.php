@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center grid-margin mb-4">
    <div>
        <h4 class="mb-3 mb-md-0 fw-bold">Dashboard Overview</h4>
        <p class="text-muted small">Ringkasan operasional CV. LISAN hari ini.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card border-0 shadow-sm border-start border-primary border-4 hover-lift">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fw-medium small text-uppercase">Total Alat Berat</p>
                        <h3 class="mb-0 fw-black">{{ $totalAlat }}</h3> 
                    </div>
                    <div class="bg-primary-soft p-2 rounded">
                        <i data-lucide="truck" class="text-primary"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-success small fw-bold">100%</span>
                    <span class="text-muted small ms-1">Unit Terdaftar</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 grid-margin stretch-card">
        <div class="card border-0 shadow-sm border-start border-info border-4 hover-lift">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fw-medium small text-uppercase">Total Operator</p>
                        <h3 class="mb-0 fw-black">{{ $totalOperator }}</h3>
                    </div>
                    <div class="bg-info-soft p-2 rounded">
                        <i data-lucide="users" class="text-info"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-info small fw-bold">Aktif</span>
                    <span class="text-muted small ms-1">Personel Lapangan</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 grid-margin stretch-card">
        <div class="card border-0 shadow-sm border-start border-warning border-4 hover-lift">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fw-medium small text-uppercase">Proyek Berjalan</p>
                        <h3 class="mb-0 fw-black">{{ $proyekAktif }}</h3>
                    </div>
                    <div class="bg-warning-soft p-2 rounded">
                        <i data-lucide="map-pin" class="text-warning"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-warning small fw-bold">On-site</span>
                    <span class="text-muted small ms-1">Lokasi Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 grid-margin stretch-card">
        <div class="card border-0 shadow-sm border-start border-success border-4 hover-lift">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fw-medium small text-uppercase">Total Pelanggan</p>
                        <h3 class="mb-0 fw-black">{{ $totalPelanggan }}</h3>
                    </div>
                    <div class="bg-success-soft p-2 rounded">
                        <i data-lucide="briefcase" class="text-success"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-success small fw-bold">Database</span>
                    <span class="text-muted small ms-1">Klien Terdaftar</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-5 text-center">
                <h6 class="text-muted fw-light italic">Area Grafik & Log Aktivitas (Akan dikembangkan setelah data master muncul)</h6>
            </div>
        </div>
    </div>
</div>
@endsection