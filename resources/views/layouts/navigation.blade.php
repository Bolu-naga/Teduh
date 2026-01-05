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
                    @if(Auth::user()->role == 'customer')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('my.bookings') ? 'active fw-bold text-primary' : 'text-secondary' }}" href="{{ route('my.bookings') }}">
                            <i class="bi bi-bag-check me-1"></i> Pesanan Saya
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->role == 'pemilik')
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
                    @if(Auth::user()->role == 'pemilik')
                    <li class="nav-item me-3 mb-2 mb-lg-0">
                        <a class="btn btn-primary rounded-pill px-3 shadow-sm" href="{{ route('kos.create') }}">
                            <i class="bi bi-plus-lg"></i> Sewakan Kos Saya
                        </a>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark fw-medium" href="#" role="button" data-bs-toggle="dropdown">
                            <span class="text-secondary small me-1">Hai,</span>
                            <span class="me-2 fw-bold text-dark">{{ Auth::user()->name }}</span>
                            @if(in_array(Auth::user()->role, ['admin', 'pemilik']))
                                <span class="badge bg-danger ms-1">Pemilik</span>
                            @else
                                <span class="badge bg-info text-dark ms-1">Customer</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2">
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-gear me-2 text-muted"></i> Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
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