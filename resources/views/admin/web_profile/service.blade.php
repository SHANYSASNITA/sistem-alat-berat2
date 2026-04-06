@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Manajemen Services (Layanan)</h6>
                
                <form action="{{ route('admin.web-profile.update') }}" method="POST">
                    @csrf
                    <div class="row mt-4">
                        <div class="col-md-6 border-end">
                            <div class="p-3 bg-light rounded mb-3">
                                <h5 class="fw-bold text-primary">Layanan 1 (Baket)</h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Layanan</label>
                                <input type="text" name="service_title_1" class="form-control" value="{{ $profile->service_title_1 ?? 'Layanan Baket' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Layanan</label>
                                <textarea name="service_desc_1" class="form-control" rows="5">{{ $profile->service_desc_1 ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded mb-3">
                                <h5 class="fw-bold text-warning">Layanan 2 (Breker)</h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Layanan</label>
                                <input type="text" name="service_title_2" class="form-control" value="{{ $profile->service_title_2 ?? 'Layanan Breker' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Layanan</label>
                                <textarea name="service_desc_2" class="form-control" rows="5">{{ $profile->service_desc_2 ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-5 py-2 text-white">Update Semua Layanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection