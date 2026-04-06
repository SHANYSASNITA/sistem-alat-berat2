@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-10 stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Manajemen About Us</h6>
                
                <form action="{{ route('admin.web-profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label">Judul About Us</label>
                                <input type="text" name="about_title" class="form-control" value="{{ $profile->about_title ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Lengkap Perusahaan</label>
                                <textarea name="about_description" class="form-control" rows="8">{{ $profile->about_description ?? '' }}</textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-5 text-center">
                            <label class="form-label d-block text-start">Foto Profil Perusahaan</label>
                            @if($profile && $profile->about_image)
                                <img src="{{ asset('storage/'.$profile->about_image) }}" class="img-fluid rounded mb-2 border" style="max-height: 200px;">
                            @endif
                            <input type="file" name="about_image" class="form-control">
                            <small class="text-muted">Format: JPG/PNG. Maks: 2MB</small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3 text-white">Simpan Perubahan About</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection