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
        <p class="text-white-50 small mb-4 text-uppercase" style="letter-spacing: 2px;">Admin Panel</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3 text-start">
                <label class="text-white-50 small mb-2">Alamat Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 text-start">
                <label class="text-white-50 small mb-2">Kata Sandi</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">MASUK SEKARANG</button>
        </form>
    </div>

</body>
</html>