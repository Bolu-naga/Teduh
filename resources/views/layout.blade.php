<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InfoKos - Cari Kos Nyaman</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .card-img-top {
            object-fit: cover;
        }

        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
        }

    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                <i class="bi bi-house-door-fill me-2"></i>InfoKos
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item me-3">
                        <span class="text-secondary small me-1">Hai,</span>
                        <span class="fw-bold text-dark">{{ Auth::user()->name ?? 'Tamu' }}</span>

                        {{-- LOGIKA BARU: Cek apakah role-nya 'admin' ATAU 'pemilik' --}}
                        @if(in_array(Auth::user()->role, ['admin', 'pemilik']))
                        <span class="badge bg-danger ms-1">Pemilik</span>
                        @else
                        <span class="badge bg-info text-dark ms-1">Customer</span>
                        @endif
                    </li>

                    {{-- JIKA DIA PEMILIK / ADMIN --}}
                    @if(in_array(Auth::user()->role, ['admin', 'pemilik']))
                    <!-- <li class="nav-item me-2">
                        <a href="{{ route('owner.bookings') }}" class="btn btn-outline-danger btn-sm px-3 rounded-pill">
                            <i class="bi bi-inbox-fill me-1"></i> Pesanan Masuk
                        </a>
                    </li> -->

                    {{-- JIKA DIA CUSTOMER --}}
                    @else
                    <!-- <li class="nav-item me-2">
                        <a href="{{ route('my.bookings') }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill">
                            <i class="bi bi-receipt me-1"></i> Pesanan Saya
                        </a>
                    </li> -->
                    @endif

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-dark btn-sm px-3 rounded-pill">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="margin-top: 80px;"></div>

    <div class="container mt-3">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

    <main class="flex-grow-1 py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="bg-white text-center py-3 mt-auto border-top text-muted small">
        <div class="container">
            &copy; {{ date('Y') }} InfoKos Apps. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
