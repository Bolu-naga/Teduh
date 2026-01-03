<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('dashboard') }}">
            <i class="bi bi-building-fill"></i> InfoKos
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold text-primary' : 'text-secondary' }}" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark fw-medium" href="#" role="button" data-bs-toggle="dropdown">
                            <span class="me-2">{{ Auth::user()->name }}</span>
                            <span class="badge bg-light text-secondary border rounded-pill fw-normal">{{ ucfirst(Auth::user()->role) }}</span>
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