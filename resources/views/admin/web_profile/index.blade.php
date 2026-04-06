@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Manajemen Konten Website (Landing Page)</h6>
                <p class="text-muted mb-4">Pusat pengaturan data Hero Section, About Us, dan Services.</p>

                <form action="{{ route('admin.web-profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="hero-tab" data-bs-toggle="tab" href="#hero" role="tab">Hero Section</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="about-tab" data-bs-toggle="tab" href="#about" role="tab">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="services-tab" data-bs-toggle="tab" href="#services" role="tab">Services (Layanan)</a>
                        </li>
                    </ul>

                    <div class="tab-content border border-top-0 p-4" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="hero" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-primary">Headline Utama</label>
                                        <input type="text" name="hero_title" class="form-control" value="{{ $profile->hero_title ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-primary">Sub-Headline (Deskripsi Singkat)</label>
                                        <textarea name="hero_description" class="form-control" rows="4">{{ $profile->hero_description ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center border-start">
                                    <label class="form-label fw-bold text-primary">Background Hero</label>
                                    
                                    {{-- PERBAIKAN PREVIEW HERO: Selalu tampilkan tag img agar JS bisa bekerja --}}
                                    <div class="mb-2">
                                        <img id="preview-hero" 
                                             src="{{ isset($profile->hero_image) && $profile->hero_image ? asset('storage/' . $profile->hero_image) : 'https://via.placeholder.com/300x150?text=Preview+Gambar' }}" 
                                             class="img-fluid rounded border shadow-sm" 
                                             style="max-height: 150px; width: 100%; object-fit: cover;"
                                             onerror="this.onerror=null;this.src='https://via.placeholder.com/300x150?text=Gambar+Tidak+Ditemukan';">
                                    </div>

                                    {{-- Tambahkan onchange dan panggil fungsi Javascript --}}
                                    <input type="file" name="hero_image" class="form-control" accept="image/*" onchange="previewImage(this, 'preview-hero')">
                                    <small class="text-muted">Gunakan gambar resolusi tinggi.</small>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="about" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-success">Judul About Us</label>
                                        <input type="text" name="about_title" class="form-control" value="{{ $profile->about_title ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-success">Deskripsi Lengkap Perusahaan</label>
                                        <textarea name="about_description" class="form-control" rows="6">{{ $profile->about_description ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center border-start">
                                    <label class="form-label fw-bold text-success">Foto Profil Perusahaan</label>
                                    
                                    {{-- PERBAIKAN PREVIEW ABOUT: Tambahkan id preview-about --}}
                                    <div class="mb-2">
                                        <img id="preview-about" 
                                             src="{{ isset($profile->about_image) && $profile->about_image ? asset('storage/' . $profile->about_image) : 'https://via.placeholder.com/150x150?text=Preview+Foto' }}" 
                                             class="img-fluid rounded border shadow-sm" 
                                             style="max-height: 150px; object-fit: cover;"
                                             onerror="this.onerror=null;this.src='https://via.placeholder.com/150x150?text=Gambar+Tidak+Ditemukan';">
                                    </div>

                                    {{-- Tambahkan onchange untuk About --}}
                                    <input type="file" name="about_image" class="form-control" accept="image/*" onchange="previewImage(this, 'preview-about')">
                                    <small class="text-muted">Format: JPG/PNG. Maks: 2MB</small>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="services" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 border-end">
                                    <h5 class="fw-bold text-warning mb-3">Layanan 1 (Baket)</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Layanan</label>
                                        <input type="text" name="service_title_1" class="form-control" value="{{ $profile->service_title_1 ?? 'Layanan Baket' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Layanan</label>
                                        <textarea name="service_desc_1" class="form-control" rows="4">{{ $profile->service_desc_1 ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="fw-bold text-warning mb-3">Layanan 2 (Breker)</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Layanan</label>
                                        <input type="text" name="service_title_2" class="form-control" value="{{ $profile->service_title_2 ?? 'Layanan Breker' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Layanan</label>
                                        <textarea name="service_desc_2" class="form-control" rows="4">{{ $profile->service_desc_2 ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div> 
                    
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg text-white px-5 shadow">
                            <i data-lucide="save" class="icon-sm me-1"></i> SIMPAN SEMUA PERUBAHAN
                        </button>
                     </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi sakti untuk Live Preview Gambar
    function previewImage(input, previewId) {
        var preview = document.getElementById(previewId);
        
        // Cek apakah ada file yang dipilih
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                // Ganti atribut src pada tag img dengan gambar yang baru dipilih
                preview.src = e.target.result;
            }
            
            // Membaca data gambar
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection