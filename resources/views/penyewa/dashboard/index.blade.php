<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penyewa - CV LISAN</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo1/style.css') }}">
</head>
<body class="p-5">
    <div class="container text-center mt-5">
        <div class="card p-4 shadow-sm">
            <h2 class="text-primary">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-secondary">Anda berhasil login sebagai <strong>Penyewa</strong>.</p>
            <hr>
            <p>ID Pelanggan Anda (UUID): <br> <span class="badge bg-info text-dark">{{ Auth::user()->pelanggan_id }}</span></p>
            
            <form action="{{ route('penyewa.logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-danger">Keluar / Logout</button>
            </form>
        </div>
    </div>
</body>
</html>