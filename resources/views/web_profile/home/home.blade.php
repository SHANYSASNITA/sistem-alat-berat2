@extends('profile') {{-- Mengacu pada file induk di atas --}}

@section('title', 'Jasa Penyewaan Alat Berat')

@section('home')
    <div class="ftco-blocks-cover-1" id="home">
        <div class="ftco-cover-1 overlay" style="background-image: url('{{ asset('assets/profile/images/hero_1.jpg') }}'); height: 100vh; background-size: cover; display: flex; align-items: center;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 text-white">
                        <h1 class="display-4 fw-bold mb-4" style="border-left: 5px solid #ffc107; padding-left: 15px;">
                            Perfection is always in our mind.
                        </h1>
                        <p class="lead">Solusi alat berat untuk pembangunan infrastruktur Nusa Tenggara Barat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('about')
    <div class="site-section py-5" id="about">
        <div class="container">
            <div class="row align-items-center">
                @foreach ($abouts as $about)
                    <div class="col-lg-6 order-lg-2">
                        <img src="{{ asset('storage/' . $about->gambar) }}" alt="About Image" class="img-fluid rounded shadow" />
                    </div>
                    <div class="col-lg-5 me-auto">
                        <h2 class="fw-bold mb-4">About Us</h2>
                        <p class="text-secondary">{{ $about->deskripsi }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('service')
    <div class="site-section py-5" style="background-color: #f8f9fa" id="service">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Our Service</h2>
            <div class="row g-4">
                @foreach ($services as $service)
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm p-4">
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $service->gambar) }}" alt="Icon" style="width: 50px;">
                            </div>
                            <h4 class="fw-bold">{{ $service->judul }}</h4>
                            <p class="text-muted small">{{ $service->deskripsi }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('tools')
    <div class="site-section py-5" id="tools">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-md-12">
                    <h2 class="fw-bold">Our Tools</h2>
                    <hr class="mx-auto border-warning border-3 opacity-100" style="width: 50px;">
                </div>
            </div>
            <div class="row g-4">
                @foreach ($tools as $tool)
                    <div class="col-md-4">
                        <div class="project-item position-relative overflow-hidden rounded">
                            {{-- Menggunakan data dari tabel AlatBerat yang dikirim sebagai $tools --}}
                            <img src="{{ asset('storage/' . ($tool->foto ?? $tool->gambar)) }}" alt="Tool" class="img-fluid w-100" />
                            <div class="p-3 bg-white border border-top-0">
                                <h5 class="fw-bold m-0">{{ $tool->nama_alat ?? 'Alat Berat' }}</h5>
                                <small class="text-warning">Tersedia untuk disewa</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection