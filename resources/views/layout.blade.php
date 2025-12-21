<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teduh App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
      <div class="container">
        <a class="navbar-brand fw-bold" href="/">🏠 Teduh</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="ms-auto">
                @auth
                    <span class="text-white me-3 small">
                        Hai, {{ Auth::user()->name }} 
                        <span class="badge bg-warning text-dark">{{ ucfirst(Auth::user()->role) }}</span>
                    </span>
                    
                    @if(Auth::user()->role == 'pemilik')
                        <a href="{{ route('kos.create') }}" class="btn btn-light btn-sm fw-bold me-1">+ Sewakan Kos</a>
                        <a href="{{ route('owner.bookings') }}" class="btn btn-info text-white btn-sm fw-bold me-1">Pesanan Masuk</a>
                    @endif

                    @if(Auth::user()->role == 'customer')
                        @endif
                    
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf 
                        <button type="submit" class="btn btn-danger btn-sm ms-2">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-warning btn-sm">Daftar</a>
                @endauth
            </div>
        </div>
      </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>