<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIAKAD')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')
    <style>
        body {
            min-height: 100vh;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #0d6efd;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 0.75rem 1rem;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .active {
            background-color: rgba(255, 255, 255, 0.25);
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block sidebar py-4">
                <div class="text-center mb-4">
                    <h4>SIAKAD</h4>
                </div>
                <ul class="nav flex-column">
                    <li><a href="/admin/dashboard"
                            class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="/admin/departemen"
                            class="{{ Request::is('admin/departemen*') ? 'active' : '' }}">Departemen</a></li>
                    <li><a href="/admin/mahasiswa"
                            class="{{ Request::is('admin/mahasiswa*') ? 'active' : '' }}">Mahasiswa</a></li>
                    <li><a href="/admin/dosen" class="{{ Request::is('admin/dosen*') ? 'active' : '' }}">Dosen</a></li>
                    <li><a href="/admin/matakuliah" class="{{ Request::is('admin/matakuliah*') ? 'active' : '' }}">Mata
                            Kuliah</a></li>
                    <li><a href="/admin/jadwalkuliah"
                            class="{{ Request::is('admin/jadwalkuliah*') ? 'active' : '' }}">Jadwal Kuliah</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link text-white ps-3">Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
