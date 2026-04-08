@extends('web_profile.layout')

@section('title', 'Home')

@section('home')
    <div class="ftco-blocks-cover-1" id="home">
        
        {{-- KITA BUAT VARIABEL PHP AGAR URL-NYA BERSIH DAN TIDAK BENTROK KUTIP --}}
        @php
            $heroBg = ($profile && $profile->hero_image) 
                      ? asset('storage/' . $profile->hero_image) 
                      : asset('assets/profile/images/hero_1.jpg');
        @endphp

        {{-- Panggil variabel $heroBg di dalam url() --}}
        <div class="ftco-cover-1 overlay" style="background-image: url('{{ $heroBg }}'); background-size: cover; background-position: center;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="line-bottom text-white mb-4" style="font-weight: 800; font-size: 3rem; line-height: 1.2;">
                            {{ $profile->hero_title ?? 'Solusi Alat Berat Terbaik Untuk Proyek Anda.' }}
                        </h1>
                        <p class="text-white mb-5" style="font-size: 1.1rem; opacity: 0.9;">
                            {{ $profile->hero_description ?? 'C.V. LISAN memberikan solusi penyewaan alat berat terpercaya di NTB.' }}
                        </p>
                        <a href="#tools" class="btn btn-primary rounded-pill px-5 py-3" style="color: black !important; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                            Lihat Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('about')
    <div class="site-section" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 order-lg-2">
                    <div style="border-radius: 10px; overflow: hidden; box-shadow: 0 15px 30px rgba(0,0,0,0.1);">
                        {{-- Gambar About dinamis: Jika ada di DB pakai DB, jika tidak pakai dummy --}}
                        <img src="{{ $profile && $profile->about_image ? asset('storage/' . $profile->about_image) : asset('assets/profile/images/hero_2.jpg') }}" 
                             alt="Tentang C.V. LISAN" class="img-fluid w-100" style="object-fit: cover; min-height: 400px;" />
                    </div>
                </div>
                <div class="col-lg-5 mr-auto order-lg-1">
                    <span class="text-primary font-weight-bold text-uppercase mb-2 d-block" style="letter-spacing: 1px;">Tentang Perusahaan</span>
                    <h2 class="mb-4" style="font-weight: 800; font-size: 2.5rem; line-height: 1.2;">
                        {{ $profile->about_title ?? 'Mitra Terpercaya Proyek Konstruksi Anda.' }}
                    </h2>
                    <p class="mb-4 text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                        {{ $profile->about_description ?? 'C.V. LISAN adalah perusahaan penyedia layanan sewa alat berat terkemuka.' }}
                    </p>
                    <ul class="list-unstyled mb-5" style="line-height: 2;">
                        <li class="mb-2 d-flex align-items-center"><i class="text-primary mr-3">✔</i> <span class="text-dark font-weight-bold">Armada Alat Berat Berkualitas</span></li>
                        <li class="mb-2 d-flex align-items-center"><i class="text-primary mr-3">✔</i> <span class="text-dark font-weight-bold">Dukungan Operator Handal</span></li>
                        <li class="mb-2 d-flex align-items-center"><i class="text-primary mr-3">✔</i> <span class="text-dark font-weight-bold">Harga Kompetitif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('service')
    <div class="site-section bg-light" id="service">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-md-8">
                    <span class="text-primary font-weight-bold text-uppercase mb-2 d-block">Layanan Kami</span>
                    <h2 class="font-weight-bold text-black" style="font-size: 2.5rem;">Solusi Pekerjaan Konstruksi</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="p-5 bg-white rounded shadow-sm text-center h-100">
                        <h3 class="font-weight-bold text-black mb-3">{{ $profile->service_title_1 ?? 'Layanan Baket' }}</h3>
                        <p class="text-muted">{{ $profile->service_desc_1 ?? 'Deskripsi layanan baket...' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="p-5 bg-white rounded shadow-sm text-center h-100">
                        <h3 class="font-weight-bold text-black mb-3">{{ $profile->service_title_2 ?? 'Layanan Breker' }}</h3>
                        <p class="text-muted">{{ $profile->service_desc_2 ?? 'Deskripsi layanan breker...' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('tools')
    <div class="site-section bg-light" id="tools">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-md-8">
                    <span class="text-primary font-weight-bold text-uppercase mb-2 d-block">Katalog Armada</span>
                    <h2 class="font-weight-bold text-black">Unit Alat Berat & Daftar Harga</h2>
                    <div style="width: 50px; height: 3px; background-color: #ffc107; margin: 15px auto;"></div>
                </div>
            </div>

            <div class="row">
                @forelse ($tools as $tool)
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 15px; overflow: hidden; background: white; position: relative;">
                            
                            {{-- Gambar Alat --}}
                            <img src="{{ asset('storage/' . $tool->foto) }}" class="card-img-top" style="height: 230px; object-fit: cover;">
                            
                            <div class="card-body p-4">
                                <h4 class="font-weight-bold text-black mb-1">{{ $tool->merk }}</h4>
                                <p class="text-muted small mb-3">{{ $tool->kode_unit }} | {{ $tool->jenis }}</p>
                                
                                {{-- BAGIAN DINAMIS PRICING & STATUS --}}
                                <div class="bg-light p-3 rounded mb-4">
                                    <h6 class="fw-bold small text-uppercase mb-3 text-primary border-bottom pb-2">Daftar Harga Sewa:</h6>
                                    
                                    @if($tool->pricing->count() > 0)
                                        @php
                                            // Ambil 1 baris data pricing terbaru untuk alat ini
                                            $price = $tool->pricing->first();
                                        @endphp

                                        {{-- CEK APAKAH PUNYA HARGA BAKET --}}
                                        @if($price->harga_baket)
                                            <div class="mb-3 border-bottom pb-2">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="small text-capitalize fw-bold text-dark"><i class="text-warning mr-1">✔</i> Layanan Baket</span>
                                                    @if($price->status == 'ready') <span class="badge bg-success" style="font-size: 0.7rem;">Siap Sewa</span>
                                                    @elseif($price->status == 'in_use') <span class="badge bg-primary" style="font-size: 0.7rem;">Beroperasi</span>
                                                    @elseif($price->status == 'maintenance') <span class="badge bg-danger" style="font-size: 0.7rem;">Perbaikan</span>
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mt-2 pl-3">
                                                    <span class="small text-muted">Tarif:</span>
                                                    <span class="fw-bold text-dark small">Rp {{ number_format($price->harga_baket, 0, ',', '.') }} / Jam</span>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- CEK APAKAH PUNYA HARGA BREKER --}}
                                        @if($price->harga_breker)
                                            <div class="mb-2">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="small text-capitalize fw-bold text-dark"><i class="text-warning mr-1">✔</i> Layanan Breker</span>
                                                    @if($price->status == 'ready') <span class="badge bg-success" style="font-size: 0.7rem;">Siap Sewa</span>
                                                    @elseif($price->status == 'in_use') <span class="badge bg-primary" style="font-size: 0.7rem;">Beroperasi</span>
                                                    @elseif($price->status == 'maintenance') <span class="badge bg-danger" style="font-size: 0.7rem;">Perbaikan</span>
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mt-2 pl-3">
                                                    <span class="small text-muted">Tarif:</span>
                                                    <span class="fw-bold text-dark small">Rp {{ number_format($price->harga_breker, 0, ',', '.') }} / Jam</span>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        {{-- JIKA DICENTANG TAPI KOSONG DUA-DUANYA --}}
                                        @if(!$price->harga_baket && !$price->harga_breker)
                                            <p class="text-danger small mb-0 font-italic text-center py-2">Hubungi admin untuk detail harga</p>
                                        @endif
                                        
                                    @else
                                        <div class="text-center py-2">
                                            <p class="text-danger small mb-0 font-italic">Hubungi admin untuk detail harga</p>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Tombol WA Otomatis --}}
                                @php
                                    $isAllMaintenance = $tool->pricing->count() > 0 && $tool->pricing->every(function($p) { return $p->status == 'maintenance'; });
                                @endphp

                                @if($isAllMaintenance)
                                    <button class="btn btn-secondary btn-block fw-bold py-2 shadow-sm" disabled style="cursor: not-allowed;">
                                        <i data-lucide="alert-circle" class="me-2"></i> ALAT SEDANG PERBAIKAN
                                    </button>
                                @else
                                    <a href="https://wa.me/628123456789?text=Halo%20CV%20LISAN,%20saya%20ingin%20tanya%20sewa%20{{ urlencode($tool->nama_alat) }}" 
                                       class="btn btn-warning btn-block fw-bold py-2 shadow-sm text-dark">
                                       <i data-lucide="message-circle" class="me-2"></i> HUBUNGI KAMI
                                    </a>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted lead">Belum ada armada yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection