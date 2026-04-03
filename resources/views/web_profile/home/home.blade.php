@extends('web_profile.layout') {{-- Memanggil kerangka layout.blade.php --}}

@section('title', 'Home')

@section('home')
    <div class="ftco-blocks-cover-1" id="home">
        <div class="ftco-cover-1 overlay" style="background-image: url('{{ asset('assets/profile/images/hero_1.jpg') }}')">
            <div class="container">
                <div class="row align-items-center">
                    {{-- Saya lebarkan sedikit kolomnya (col-lg-6) agar teks panjangnya lebih rapi --}}
                    <div class="col-lg-6">
                        
                        {{-- 1. Headline Utama --}}
                        <h1 class="line-bottom text-white mb-4" style="font-weight: 800; font-size: 3rem; line-height: 1.2;">
                            Solusi Alat Berat Terbaik Untuk Proyek Anda.
                        </h1>
                        
                        {{-- 2. Sub-Headline (Deskripsi) --}}
                        <p class="text-white mb-5" style="font-size: 1.1rem; opacity: 0.9;">
                            C.V. LISAN memberikan solusi penyewaan alat berat terpercaya di NTB dengan transparansi monitoring data untuk menunjang kesuksesan proyek konstruksi Anda.
                        </p>
                        
                        {{-- 3. Tombol CTA (Call to Action) --}}
                        <a href="#tools" class="btn btn-primary rounded-pill px-5 py-3" style="color: black !important; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                            Lihat Katalog
                        </a>

                    </div>
                    <div class="col-lg-6 ml-auto"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('about')
    <div class="site-section" id="about">
        <div class="container">
            <div class="row align-items-center">
                
                {{-- Bagian Gambar (Di Kanan) --}}
                <div class="col-lg-6 mb-5 mb-lg-0 order-lg-2">
                    <div style="border-radius: 10px; overflow: hidden; box-shadow: 0 15px 30px rgba(0,0,0,0.1);">
                        {{-- Memakai gambar dummy bawaan template sementara --}}
                        <img src="{{ asset('assets/profile/images/hero_2.jpg') }}" alt="Tentang C.V. LISAN" class="img-fluid w-100" style="object-fit: cover; min-height: 400px;" />
                    </div>
                </div>
                
                {{-- Bagian Teks (Di Kiri) --}}
                <div class="col-lg-5 mr-auto order-lg-1">
                    <span class="text-primary font-weight-bold text-uppercase mb-2 d-block" style="letter-spacing: 1px;">Tentang Perusahaan</span>
                    
                    <h2 class="mb-4" style="font-weight: 800; font-size: 2.5rem; line-height: 1.2;">Mitra Terpercaya Proyek Konstruksi Anda.</h2>
                    
                    <p class="mb-4 text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                        C.V. LISAN adalah perusahaan penyedia layanan sewa alat berat terkemuka. Kami berkomitmen untuk memberikan solusi alat berat terbaik guna menunjang produktivitas dan kelancaran setiap proyek yang Anda tangani.
                    </p>
                    
                    <ul class="list-unstyled mb-5" style="line-height: 2;">
                        <li class="mb-2 d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-primary mr-3" viewBox="0 0 16 16">
                              <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            <span class="text-dark font-weight-bold">Armada Alat Berat Berkualitas & Terawat</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-primary mr-3" viewBox="0 0 16 16">
                              <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            <span class="text-dark font-weight-bold">Dukungan Operator Handal & Bersertifikat</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-primary mr-3" viewBox="0 0 16 16">
                              <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            <span class="text-dark font-weight-bold">Harga Sewa Kompetitif & Transparan</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection

{{-- ========================================== --}}
{{-- BAGIAN LAYANAN (SERVICES) --}}
{{-- ========================================== --}}
@section('service')
    <div class="site-section bg-light" id="service">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-md-8">
                    <span class="text-primary font-weight-bold text-uppercase mb-2 d-block" style="letter-spacing: 1px;">Layanan Kami</span>
                    <h2 class="font-weight-bold text-black" style="font-size: 2.5rem;">Solusi Pekerjaan Konstruksi</h2>
                    <div style="width: 50px; height: 3px; background-color: #ffc107; margin: 15px auto;"></div>
                </div>
            </div>

            <div class="row">
                {{-- Card Layanan 1 (Baket) --}}
                <div class="col-md-6 mb-4 mb-lg-0">
                    <div class="p-5 bg-white rounded shadow-sm text-center h-100 transition-hover">
                        <div class="mb-4">
                            {{-- Icon Excavator/Baket (SVG) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#ffc107" viewBox="0 0 16 16">
                                <path d="M6.5 0a.5.5 0 0 0-.5.5v1h-1A1.5 1.5 0 0 0 3.5 3v.5H1.5a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 .5.5h2v2.5A1.5 1.5 0 0 0 5 12.5h1v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1h2v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1h1a1.5 1.5 0 0 0 1.5-1.5v-6A1.5 1.5 0 0 0 13.5 3h-2v-.5A1.5 1.5 0 0 0 10 1h-1V.5a.5.5 0 0 0-.5-.5h-2ZM5 11h6V4.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0-.5.5V11Z"/>
                            </svg>
                        </div>
                        <h3 class="font-weight-bold text-black mb-3">Layanan Baket</h3>
                        <p class="text-muted" style="line-height: 1.8;">Sangat efisien untuk pekerjaan penggalian tanah, pembuatan saluran air, pembersihan lahan, hingga pemuatan material konstruksi ke *dump truck*.</p>
                    </div>
                </div>

                {{-- Card Layanan 2 (Breker) --}}
                <div class="col-md-6">
                    <div class="p-5 bg-white rounded shadow-sm text-center h-100 transition-hover">
                        <div class="mb-4">
                            {{-- Icon Hammer/Breker (SVG) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#ffc107" viewBox="0 0 16 16">
                                <path d="M1 12.5a.5.5 0 0 0 .5.5h3.5a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5H1.5a.5.5 0 0 0-.5.5v2Zm11-10a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-2ZM1 5.5a.5.5 0 0 0 .5.5h3.5a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5H1.5a.5.5 0 0 0-.5.5v2Zm11 7a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-2Z"/>
                                <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0Z"/>
                                <path d="M15.5 2.5a.5.5 0 0 1-.5.5h-2v10h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h2v-10H1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h14a.5.5 0 0 1 .5.5v1Z"/>
                            </svg>
                        </div>
                        <h3 class="font-weight-bold text-black mb-3">Layanan Breker</h3>
                        <p class="text-muted" style="line-height: 1.8;">Solusi tangguh untuk pengerjaan pembongkaran struktur beton, penghancuran batu keras, serta pengerjaan penggalian di medan berbatu yang sulit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- ========================================== --}}
{{-- BAGIAN ALUR KERJA & CTA (MENGGANTIKAN EXTRA SECTION) --}}
{{-- ========================================== --}}
@section('extra_section')
    {{-- Cara Mudah Menyewa --}}
    <div class="site-section bg-white">
        <div class="container text-center">
            <div class="row justify-content-center mb-5">
                <div class="col-md-8">
                    <h2 class="font-weight-bold text-black" style="font-size: 2.2rem;">Cara Mudah Menyewa</h2>
                    <p class="text-muted mt-2">Proses konfirmasi digital yang memberikan kepastian bagi proyek Anda.</p>
                </div>
            </div>
            
            <div class="row mt-5">
                {{-- Step 1 --}}
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="d-inline-block bg-warning text-dark rounded-circle p-4 mb-4 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </div>
                    <h4 class="font-weight-bold text-black text-uppercase" style="font-size: 1.1rem;">Pilih Alat</h4>
                    <p class="text-muted text-sm mt-3 px-3">Cek katalog real-time di fitur <strong>Tools</strong> untuk melihat unit yang tersedia.</p>
                </div>

                {{-- Step 2 --}}
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="d-inline-block bg-warning text-dark rounded-circle p-4 mb-4 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3 2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V2zm6 11a1 1 0 1 0-2 0 1 1 0 0 0 2 0z"/>
                        </svg>
                    </div>
                    <h4 class="font-weight-bold text-black text-uppercase" style="font-size: 1.1rem;">Konfirmasi Digital</h4>
                    <p class="text-muted text-sm mt-3 px-3">Hubungi kami untuk mendapatkan konfirmasi jadwal tanpa perlu datang ke lokasi agen.</p>
                </div>

                {{-- Step 3 --}}
                <div class="col-md-4">
                    <div class="d-inline-block bg-warning text-dark rounded-circle p-4 mb-4 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                        </svg>
                    </div>
                    <h4 class="font-weight-bold text-black text-uppercase" style="font-size: 1.1rem;">Unit Dikirim</h4>
                    <p class="text-muted text-sm mt-3 px-3">Armada beserta operator profesional siap bekerja di lokasi proyek Anda di seluruh NTB.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA (Call to Action) --}}
    <div class="site-section" style="background-color: #f8f9fa;">
        <div class="container text-center py-4">
            <h3 class="font-weight-bold text-black mb-4">Siap Memulai Proyek Anda?</h3>
            <a href="#tools" class="btn btn-warning rounded-pill px-5 py-3" style="color: black !important; font-weight: 700; font-size: 1.1rem; letter-spacing: 0.5px;">
                LIHAT SEMUA ARMADA &nbsp; &rarr;
            </a>
        </div>
    </div>
@endsection

{{-- ========================================== --}}
{{-- BAGIAN KATALOG ARMADA (TOOLS) --}}
{{-- ========================================== --}}
@section('tools')
    <div class="site-section bg-light" id="tools">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-md-8">
                    <span class="text-primary font-weight-bold text-uppercase mb-2 d-block" style="letter-spacing: 1px;">Katalog Armada</span>
                    <h2 class="font-weight-bold text-black" style="font-size: 2.5rem;">Unit Alat Berat Tersedia</h2>
                    <div style="width: 50px; height: 3px; background-color: #ffc107; margin: 15px auto;"></div>
                </div>
            </div>

            <div class="row">
                {{-- Mengecek apakah variabel $tools dari web.php ada isinya --}}
                @forelse ($tools as $tool)
                    {{-- TAMPILAN JIKA DATABASE ADA ISINYA --}}
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 12px; overflow: hidden;">
                            {{-- Label Status --}}
                            <div class="position-absolute mt-3 ml-3" style="z-index: 2;">
                                <span class="badge badge-success px-3 py-2" style="font-size: 0.85rem; border-radius: 20px;">Tersedia</span>
                            </div>
                            
                            {{-- Gambar Alat (Akan menyesuaikan ukuran otomatis tanpa peyang) --}}
                            <img src="{{ url('storage/' . $tool->gambar) }}" class="card-img-top" alt="{{ $tool->nama_alat }}" style="height: 250px; object-fit: cover;">
                            
                            <div class="card-body p-4">
                                <h4 class="card-title font-weight-bold text-black mb-3">{{ $tool->nama_alat ?? 'Nama Alat Berat' }}</h4>
                                
                                <div class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.8;">
                                    <span class="d-block"><strong>Kategori:</strong> {{ $tool->kategori ?? 'Alat Berat Umum' }}</span>
                                    <span class="d-block"><strong>Harga Sewa:</strong> Rp {{ number_format($tool->harga_sewa ?? 0, 0, ',', '.') }} / Jam</span>
                                </div>
                                
                                <a href="{{ route('penyewa.login') }}" class="btn btn-outline-warning btn-block font-weight-bold py-2" style="border-width: 2px; color: black;">SEWA SEKARANG</a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- TAMPILAN SEMENTARA JIKA DATABASE MASIH KOSONG --}}
                    {{-- Dummy Card 1 --}}
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 12px; overflow: hidden;">
                            <div class="position-absolute mt-3 ml-3" style="z-index: 2;">
                                <span class="badge badge-success px-3 py-2" style="font-size: 0.85rem; border-radius: 20px;">Tersedia</span>
                            </div>
                            {{-- Menggunakan gambar dummy dari template --}}
                            <img src="{{ asset('assets/profile/images/hero_1.jpg') }}" class="card-img-top" alt="Excavator PC200" style="height: 250px; object-fit: cover;">
                            <div class="card-body p-4">
                                <h4 class="card-title font-weight-bold text-black mb-3">Excavator Komatsu PC200</h4>
                                <div class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.8;">
                                    <span class="d-block"><strong>Kategori:</strong> Penggalian (Excavating)</span>
                                    <span class="d-block"><strong>Harga Sewa:</strong> Rp 200.000 / Jam</span>
                                </div>
                                <a href="{{ route('penyewa.login') }}" class="btn btn-outline-warning btn-block font-weight-bold py-2" style="border-width: 2px; color: black;">SEWA SEKARANG</a>
                            </div>
                        </div>
                    </div>

                    {{-- Dummy Card 2 --}}
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 12px; overflow: hidden;">
                            <div class="position-absolute mt-3 ml-3" style="z-index: 2;">
                                <span class="badge badge-success px-3 py-2" style="font-size: 0.85rem; border-radius: 20px;">Tersedia</span>
                            </div>
                            <img src="{{ asset('assets/profile/images/hero_2.jpg') }}" class="card-img-top" alt="Bulldozer D85ESS" style="height: 250px; object-fit: cover;">
                            <div class="card-body p-4">
                                <h4 class="card-title font-weight-bold text-black mb-3">Bulldozer D85ESS</h4>
                                <div class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.8;">
                                    <span class="d-block"><strong>Kategori:</strong> Perataan Lahan</span>
                                    <span class="d-block"><strong>Harga Sewa:</strong> Rp 250.000 / Jam</span>
                                </div>
                                <a href="{{ route('penyewa.login') }}" class="btn btn-outline-warning btn-block font-weight-bold py-2" style="border-width: 2px; color: black;">SEWA SEKARANG</a>
                            </div>
                        </div>
                    </div>

                    {{-- Dummy Card 3 --}}
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 12px; overflow: hidden;">
                            <div class="position-absolute mt-3 ml-3" style="z-index: 2;">
                                <span class="badge badge-secondary px-3 py-2" style="font-size: 0.85rem; border-radius: 20px;">Sedang Disewa</span>
                            </div>
                            <img src="{{ asset('assets/profile/images/hero_3.jpg') }}" class="card-img-top" alt="Dump Truck Hino" style="height: 250px; object-fit: cover; filter: grayscale(50%);">
                            <div class="card-body p-4">
                                <h4 class="card-title font-weight-bold text-black mb-3">Dump Truck Hino 500</h4>
                                <div class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.8;">
                                    <span class="d-block"><strong>Kategori:</strong> Pengangkutan (Hauling)</span>
                                    <span class="d-block"><strong>Harga Sewa:</strong> Rp 150.000 / Jam</span>
                                </div>
                                <a href="{{ route('penyewa.login') }}" class="btn btn-light btn-block font-weight-bold py-2" style="border-width: 2px; pointer-events: none;">TIDAK TERSEDIA</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection