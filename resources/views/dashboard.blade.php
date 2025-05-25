<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">
            <h1 class="mb-5">Haloo 👋</h1>
            <h3 class="mb-3">Kamu login dengan akun</h3>
            <h4 class="text-primary">{{ Auth::user()->name }}</h4>
            <p class="mb-4">Sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong></p>

            @php
                $dashboardRoute = match (Auth::user()->role) {
                    'admin' => route('admin.dashboard'),
                    'dosen' => route('dosen.dashboard'),
                    'mahasiswa' => route('mahasiswa.dashboard'),
                    default => '#',
                };
            @endphp

            <a href="{{ $dashboardRoute }}" class="btn btn-primary">
                Masuk ke Dashboard {{ ucfirst(Auth::user()->role) }}
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
