<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InfoKos - Cari Kos Murah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
      <div class="container">
        <a class="navbar-brand fw-bold" href="/">🏠 InfoKos</a>
        
        <div class="ms-auto">
            @auth
                <span class="text-white me-3 small">Halo, {{ Auth::user()->name }}</span>
                <a href="{{ route('kos.create') }}" class="btn btn-light btn-sm fw-bold">+ Sewakan Kos</a>
                
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
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>