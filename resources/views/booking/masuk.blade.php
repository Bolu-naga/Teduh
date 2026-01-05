@extends('layout')

@section('content')
<div class="container mt-4">
<div class="d-flex justify-content-between align-items-center mb-4">
    
    {{-- BAGIAN KIRI: JUDUL & SUB-JUDUL --}}
    <div>
        <h2 class="fw-bold text-danger">
            <i class="bi bi-shop-window me-2"></i>Manajemen Pesanan
        </h2>
        <div class="text-muted small">
            Pantau semua permintaan sewa kos di sini.
        </div>
    </div>

    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
    </a>
</div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        
        <div class="card-header bg-white border-bottom-0 pb-0 pt-3">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active fw-bold text-danger" href="#">
                        Pesanan Masuk 
                        <span class="badge bg-danger rounded-pill ms-1">{{ count($pesanan) }}</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link text-muted" href="#">Perlu Konfirmasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="#">Sudah Dihubungi</a>
                </li> -->
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Data Pemesan</th>
                            <th class="py-3">Kos Dipesan</th>
                            <th class="py-3">Rencana Masuk</th>
                            <th class="py-3">Status</th>
                            <th class="text-end pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $index => $item)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->user->name ?? 'User Terhapus' }}</div>
                                <div class="text-muted small">
                                    <i class="bi bi-envelope me-1"></i>{{ $item->user->email ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $item->kos->nama_kos }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</span>
                                    <small class="text-muted">Durasi: 1 Bulan</small>
                                </div>
                            </td>
                            <td>
                                @if($item->status == 'pending')
                                    <span class="badge rounded-pill bg-warning text-dark">
                                        <i class="bi bi-clock me-1"></i> Pending
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-success">
                                        <i class="bi bi-check-circle me-1"></i> Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="https://wa.me/{{ $item->user->no_hp ?? '' }}?text=Halo%20{{ $item->user->name }},%20terkait%20pesanan%20kos%20{{ $item->kos->nama_kos }}..." 
                                       target="_blank" 
                                       class="btn btn-success btn-sm">
                                        <i class="bi bi-whatsapp me-1"></i> Hubungi
                                    </a>
                                    
                                    <button class="btn btn-outline-secondary btn-sm" title="Arsipkan" disabled>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted mb-3">
                                    <i class="bi bi-inbox display-4"></i>
                                </div>
                                <h5 class="text-muted">Tidak ada pesanan masuk</h5>
                                <p class="text-muted small">Belum ada customer yang mengajukan sewa.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection