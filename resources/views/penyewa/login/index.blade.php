<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Penyewa - CV LISAN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/demo1/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>
<body>
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content container d-flex align-items-center justify-content-center">

                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-10 col-lg-10 col-xl-10 mx-auto">
                        <div class="card" style="overflow: hidden;">
                            <div class="row g-0"> <div class="col-md-5 pe-md-0">
                                    <div class="auth-side-wrapper" 
                                        style="background-image: url('{{ asset('assets/images/gambar1.jpeg') }}'); 
                                                background-size: cover; 
                                                background-position: center; 
                                                height: 100%; 
                                                min-height: 500px;">
                                    </div>
                                </div>
                                <div class="col-md-7 ps-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <a href="#" class="nobleui-logo d-block mb-2">SIMAT<span> LISAN</span></a>
                                        <h5 class="text-secondary fw-normal mb-4">Selamat Datang! Silakan masuk ke akun penyewa Anda.</h5>
                                        
                                        <form class="forms-sample" action="#" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="userEmail" class="form-label">Alamat Email</label>
                                                <input type="email" class="form-control" id="userEmail" name="email" placeholder="Email" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="userPassword" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="userPassword" name="password" autocomplete="current-password" placeholder="Password" required>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input type="checkbox" class="form-check-input" id="authCheck">
                                                <label class="form-check-label" for="authCheck">Ingat saya</label>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Login</button>
                                                <button type="button" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                                                    <i data-lucide="info" class="btn-icon-prepend"></i> Panduan Pengguna
                                                </button>
                                            </div>
                                            <p class="mt-3 text-secondary">Belum punya akun penyewa? <a href="{{ url('/penyewa/register') }}">Daftar Sekarang</a></p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      lucide.createIcons();
    </script>
</body>
</html>