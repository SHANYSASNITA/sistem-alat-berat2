<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - C.V. LISAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-dark: #1a1c23;
            --accent-color: #ffc107;
        }
        body {
            background-color: var(--primary-dark);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: #252830;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }
        .form-control {
            background: #1a1c23;
            border: 1px solid #3d414d;
            color: white;
            padding: 12px;
        }
        .form-control:focus {
            background: #1a1c23;
            border-color: var(--accent-color);
            color: white;
            box-shadow: none;
        }
        .btn-login {
            background-color: var(--accent-color);
            border: none;
            color: var(--primary-dark);
            font-weight: 700;
            padding: 12px;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #e5ac00;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="login-card text-center">
        <h3 class="fw-bold mb-1" style="color: var(--accent-color);">C.V. LISAN</h3>
        <p class="text-white-50 small mb-4 text-uppercase" style="letter-spacing: 3px;">Admin Panel</p>
        <p class="text-white-50 small mb-4 text-uppercase" style="letter-spacing: 1px;">Halaman ini hanya untuk login admin</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            {{-- Munculin alert merah kalau email/password salah --}}
            @error('login_error')
                <div class="p-2 mb-3 rounded" style="background-color: rgba(220, 53, 69, 0.15); border: 1px solid #dc3545; color: #ff6b72; font-size: 14px; text-align: left;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $message }}
                </div>
            @enderror

            {{-- Form Input Email --}}
            <div class="mb-3 text-start">
                <label class="text-white-50 small mb-2">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autofocus>
                
                @error('email')
                    <div class="mt-1" style="color: #ff6b72; font-size: 12px;"><i class="bi bi-info-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            {{-- Form Input Password --}}
            <div class="mb-4 text-start">
                <label class="text-white-50 small mb-2">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                
                @error('password')
                    <div class="mt-1" style="color: #ff6b72; font-size: 12px;"><i class="bi bi-info-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">LOGIN</button>
        </form>
    </div>

</body>
</html>