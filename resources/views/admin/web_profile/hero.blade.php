@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-8 stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Manajemen Hero Section</h6>
                <p class="text-muted mb-4">Edit tulisan utama yang muncul di bagian paling atas Landing Page.</p>

                <form action="{{ route('admin.web-profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Headline Utama</label>
                        <input type="text" name="hero_title" class="form-control" value="{{ $profile->hero_title ?? 'Solusi Alat Berat Terbaik Untuk Proyek Anda.' }}">
                        <small class="text-muted">Gunakan kalimat yang menarik perhatian pengunjung.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sub-Headline (Deskripsi Singkat)</label>
                        <textarea name="hero_description" class="form-control" rows="4">{{ $profile->hero_description ?? '' }}</textarea>
                    </div>


                        <div class="d-flex justify-content-end mt-4">
                            {{-- <a href="{{ route('web_profile.hero') }}" class="btn btn-secondary me-2">Batal</a> --}}
                            <button type="submit" class="btn btn-primary text-white">
                                <i data-lucide="save" class="icon-sm me-1"></i> Simpan
                            </button>
                        </div>


                    
                    {{-- <button type="submit" class="btn btn-primary text-white">Update Hero Section</button> --}}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection