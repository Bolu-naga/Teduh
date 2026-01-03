@extends('layouts.app')

@section('content')

<div class="row align-items-center mb-5">
    <div class="col-md-6">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-building"></i> Daftar Pilihan Kos
        </h2>
        <p class="text-muted mt-1">Temukan tempat tinggal nyaman impianmu disini.</p>
    </div>
    <div class="col-md-6">
        <form action="/" method="GET">
            <div class="input-group shadow-sm">
                <input type="text" name="search" class="form-control border-0 py-2" 
                       placeholder="Cari nama kos atau lokasi..." value="{{ request('search') }}">
                <button class="btn btn-primary px-4" type="submit">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Gagal Mengajukan Sewa:</strong>
    <ul class="mb-0 mt-1">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
    @forelse($data_kos as $kos)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
            
            @if($kos->images->count() > 0)
            <div id="carousel{{ $kos->id }}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner rounded-top">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/' . $kos->gambar) }}" class="d-block w-100"
                             style="height: 250px; object-fit: cover" alt="Cover">
                    </div>
                    @foreach($kos->images as $img)
                    <div class="carousel-item">
                        <img src="{{ asset('images/gallery/' . $img->image_path) }}" class="d-block w-100"
                             style="height: 250px; object-fit: cover" alt="Galeri">
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $kos->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $kos->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
            @elseif($kos->gambar)
                <img src="{{ asset('images/' . $kos->gambar) }}" class="card-img-top" 
                     style="height: 250px; object-fit: cover" alt="Cover">
            @else
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-top" style="height: 250px;">
                    <i class="bi bi-image-fill fs-1"></i>
                </div>
            @endif

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title fw-bold mb-0 text-dark">{{ $kos->nama_kos }}</h5>
                    <span class="badge bg-light text-primary border border-primary">
                        {{ $kos->lokasi }}
                    </span>
                </div>
                
                <h5 class="text-primary fw-bold mb-3">
                    Rp {{ number_format($kos->harga) }} <small class="text-muted fs-6 fw-normal">/bulan</small>
                </h5>

                <p class="card-text text-secondary small mb-3 border-top pt-2">
                    {{ Str::limit($kos->deskripsi, 80) }}
                </p>

                <div class="d-grid gap-2">
                    @auth
                        @if(Auth::user()->role == 'pemilik' && Auth::id() == $kos->user_id)
                            <div class="btn-group">
                                <a href="{{ route('kos.edit', $kos->id) }}" class="btn btn-warning text-white">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('kos.destroy', $kos->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kos ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100 rounded-0 rounded-end">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>

                        @elseif(Auth::user()->role == 'customer')
                            <form action="{{ route('booking.store', $kos->id) }}" method="POST">
                                @csrf
                                <div class="input-group input-group-sm mb-2">
                                    <input type="date" name="tanggal_mulai" class="form-control" required>
                                    <button type="submit" class="btn btn-primary">
                                        Ajukan Sewa
                                    </button>
                                </div>
                            </form>
                            <a href="https://wa.me/{{ $kos->no_hp }}?text=Halo..." target="_blank" class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp"></i> Chat Pemilik
                            </a>
                        @endif

                        

                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Login untuk Pesan
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
            <h4>Belum ada data kos yang tersedia.</h4>
            <p>Silakan kembali lagi nanti atau coba kata kunci lain.</p>
        </div>
    </div>
    @endforelse
</div>
@endsection