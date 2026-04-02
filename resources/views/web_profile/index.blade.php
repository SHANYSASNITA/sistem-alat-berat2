<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.V. LISAN - Jasa Penyewaan Alat Berat</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root { --primary-dark: #1a1c23; --accent-color: #ffc107; }
        body { font-family: 'Segoe UI', sans-serif; scroll-behavior: smooth; }
        .navbar { transition: all 0.4s; background-color: transparent !important; }
        .navbar.scrolled { background-color: var(--primary-dark) !important; padding: 10px 0; }
        .nav-link { color: #fff !important; }
        .nav-link:hover { color: var(--accent-color) !important; }
        .site-section { padding: 7em 0; }
    </style>
</head>
<body>

    <nav id="mainNav" class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand text-warning fw-bold" href="#home">CV. LISAN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#service">Service</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tools">Tools</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-warning rounded-pill px-4 fw-bold" href="{{ route('penyewa.login') }}">
                            Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="ftco-blocks-cover-1" id="home">
        <div class="ftco-cover-1 overlay" style="background-image: url('{{ asset('assets/images/hero_1.jpg') }}'); height: 100vh; background-size: cover; display: flex; align-items: center; background-position: center;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 text-white" style="background: rgba(0,0,0,0.5); padding: 30px; border-radius: 10px;">
                        <h1 class="display-4 fw-bold mb-4" style="border-left: 5px solid #ffc107; padding-left: 15px;">
                            Perfection is always in our mind.
                        </h1>
                        <p class="lead">Solusi alat berat untuk pembangunan infrastruktur Nusa Tenggara Barat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section py-5" id="about">
        <div class="container">
            <div class="row align-items-center">
                @if(isset($abouts) && count($abouts) > 0)
                    @foreach ($abouts as $about)
                        <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                            <img src="{{ asset('storage/' . $about->gambar) }}" alt="About Image" class="img-fluid rounded shadow" />
                        </div>
                        <div class="col-lg-5 me-auto">
                            <h2 class="fw-bold mb-4">About Us</h2>
                            <p class="text-secondary">{{ $about->deskripsi }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-12 text-center">
                        <h2 class="fw-bold mb-4">About Us</h2>
                        <p class="text-secondary">C.V. LISAN adalah penyedia layanan penyewaan alat berat terpercaya.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="site-section py-5" style="background-color: #f8f9fa" id="service">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Our Service</h2>
            <div class="row g-4">
                @if(isset($services) && count($services) > 0)
                    @foreach ($services as $service)
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm p-4 text-center">
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $service->gambar) }}" alt="Icon" style="width: 50px;">
                                </div>
                                <h4 class="fw-bold">{{ $service->judul }}</h4>
                                <p class="text-muted small">{{ $service->deskripsi }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center"><p>Belum ada data layanan.</p></div>
                @endif
            </div>
        </div>
    </div>

    <div class="site-section py-5" id="tools">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-md-12">
                    <h2 class="fw-bold">Our Tools</h2>
                    <hr class="mx-auto border-warning border-3 opacity-100" style="width: 50px;">
                </div>
            </div>
            <div class="row g-4">
                @if(isset($tools) && count($tools) > 0)
                    @foreach ($tools as $tool)
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm overflow-hidden rounded">
                                <img src="{{ asset('storage/' . ($tool->foto ?? $tool->gambar)) }}" alt="Tool" class="card-img-top" style="height: 250px; object-fit: cover;" />
                                <div class="card-body bg-white border-top-0">
                                    <h5 class="fw-bold m-0">{{ $tool->nama_alat ?? 'Alat Berat' }}</h5>
                                    <small class="text-success fw-bold"><i class="bi bi-check-circle me-1"></i> Tersedia untuk disewa</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center"><p>Belum ada alat berat yang aktif.</p></div>
                @endif
            </div>
        </div>
    </div>

    <footer class="py-5 bg-dark text-white text-center">
        <div class="container">
            <p>&copy; 2026 C.V. Lisan. Terpercaya di NTB.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            window.scrollY > 50 ? nav.classList.add('scrolled') : nav.classList.remove('scrolled');
        });
    </script>
</body>
</html>