<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('dashboard') }}">
            <i class="bi bi-house-door-fill"></i> InfoKos
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    {{-- JIKA CUSTOMER --}}
                    @if(Auth::user()->role == 'customer')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('my.bookings') ? 'active fw-bold text-primary' : 'text-secondary' }}" href="{{ route('my.bookings') }}">
                            <i class="bi bi-bag-check me-1"></i> Pesanan Saya
                        </a>
                    </li>
                    @endif

                    {{-- JIKA PEMILIK --}}
                    @if(in_array(Auth::user()->role, ['admin', 'pemilik']))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('owner.bookings') ? 'active fw-bold text-primary' : 'text-secondary' }}" href="{{ route('owner.bookings') }}">
                            <i class="bi bi-inbox me-1"></i> Pesanan Masuk
                        </a>
                    </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    {{-- Tombol 'Sewakan Kos' (Khusus Pemilik) --}}
                    @if(Auth::user()->role == 'pemilik')
                    <li class="nav-item me-3 d-none d-lg-block">
                        <a class="btn btn-primary rounded-pill px-3 shadow-sm" href="{{ route('kos.create') }}">
                            <i class="bi bi-plus-lg"></i> Sewakan Kos Saya
                        </a>
                    </li>
                    @endif

                    <li class="nav-item d-flex align-items-center">
                        <span class="text-secondary small me-1">Hai,</span>
                        <span class="fw-bold text-dark me-2">{{ Auth::user()->name }}</span>
                        
                        @if(in_array(Auth::user()->role, ['admin', 'pemilik']))
                            <span class="badge bg-danger rounded-pill">Pemilik</span>
                        @else
                            <span class="badge bg-info text-dark rounded-pill">Customer</span>
                        @endif
                    </li>

                    <!-- <li class="nav-item ms-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3" title="Edit Profile">
                            <i class="bi bi-person-gear"></i> Profile
                        </a>
                    </li> -->

                    {{-- TOMBOL LOGOUT (Hitam, Terpisah) --}}
                    <li class="nav-item ms-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-dark rounded-pill px-4">
                                Logout
                            </button>
                        </form>
                    </li>

                @else
                    {{-- JIKA BELUM LOGIN --}}
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary px-4 me-2 rounded-pill">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-primary px-4 rounded-pill">Daftar</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>