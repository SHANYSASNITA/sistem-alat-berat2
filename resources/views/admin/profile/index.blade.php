@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
        </ol>
    </nav>

    <div class="row">
        @if (session('success'))
            <div class="col-12 mb-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i data-lucide="check-circle" class="icon-sm me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Informasi Akun</h6>
                    
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i data-lucide="user" class="icon-sm"></i></span>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            </div>
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i data-lucide="mail" class="icon-sm"></i></span>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            </div>
                            @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">
                            <i data-lucide="save" class="icon-sm me-1"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card border-0 shadow-sm" style="background-color: #f8f9fa;">
                <div class="card-body">
                    <h6 class="card-title mb-4 text-danger"><i data-lucide="lock" class="icon-sm me-1"></i> Ubah Password</h6>
                    
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label text-muted">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan password lama" required>
                            @error('current_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                            @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password baru" required>
                        </div>

                        <button type="submit" class="btn btn-danger mt-2">
                            <i data-lucide="key" class="icon-sm me-1"></i> Ganti Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection