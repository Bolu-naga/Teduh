@extends('layout')

@section('content')

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold">Daftar Info Kos</h2>
        @auth
            <p class="text-muted">Anda Login sebagai: <strong>{{ ucfirst(Auth::user()->role) }}</strong></p>
        @endauth
    </div>
    <div class="col-md-6">
        <form action="/" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama kos atau lokasi..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    @forelse($data_kos as $kos)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            @if($kos->gambar)
                <img src="{{ asset('storage/' . $kos->gambar) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
            @else
                <div class="d-flex align-items-center justify-content-center bg-secondary text-white" style="height: 200px;">
                    <span>Tidak ada foto</span>
                </div>
            @endif
            
            <div class="card-body">
                <h5 class="card-title fw-bold">{{ $kos->nama_kos }}</h5>
                <h6 class="text-primary fw-bold">Rp {{ number_format($kos->harga) }} / bulan</h6>
                <p class="text-muted small mb-2">📍 {{ $kos->lokasi }}</p>
                <p class="card-text text-secondary small">{{ Str::limit($kos->deskripsi, 60) }}</p>
                
                <div class="mt-3">
                    @auth
                        @if(Auth::user()->role == 'pemilik' && Auth::id() == $kos->user_id)
                            <div class="d-flex gap-2">
                                <a href="{{ route('kos.edit', $kos->id) }}" class="btn btn-warning btn-sm w-50">Edit</a>
                                <form action="{{ route('kos.destroy', $kos->id) }}" method="POST" class="w-50">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </div>
                        
                        @elseif(Auth::user()->role == 'customer')
                            <form action="{{ route('booking.store', $kos->id) }}" method="POST">
                                @csrf
                                <label class="small fw-bold">Mau masuk tanggal berapa?</label>
                                <div class="input-group input-group-sm mb-2">
                                    <input type="date" name="tanggal_mulai" class="form-control" required>
                                    <button type="submit" class="btn btn-primary">Ajukan Sewa</button>
                                </div>
                            </form>
                            <a href="https://wa.me/{{ $kos->no_hp }}" target="_blank" class="btn btn-success btn-sm w-100 mt-1">Chat Pemilik via WA</a>
                        @endif

                    @else
                        <div class="d-grid">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login untuk Pesan</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @empty
        <div class="col-12 text-center py-5">
            <h4 class="text-muted">Belum ada data kos.</h4>
        </div>
    @endforelse
</div>
@endsection