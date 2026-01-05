@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-inbox me-2"></i>Kotak Pesanan </h2>
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
            <ul class="nav nav-tabs card-header-tabs" id="bookingTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active fw-bold text-primary" href="#">
                        Pesanan <span class="badge bg-primary rounded-pill ms-1">{{ count($bookings) }}</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link text-muted" href="#">
                        Menunggu Konfirmasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="#">
                        Sedang Berjalan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="#">
                        Riwayat/Batal
                    </a>
                </li> -->
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Nama Kos</th>
                            <th class="py-3">Lokasi</th>
                            <th class="py-3">Tanggal Masuk</th>
                            <th class="py-3">Status</th>
                            <th class="text-end pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $item)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->kos->nama_kos }}</div>
                                <small class="text-muted">Rp {{ number_format($item->kos->harga) }}/bln</small>
                            </td>
                            <td>{{ $item->kos->lokasi }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</span>
                                    <small class="text-muted">Durasi: 1 Bulan</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-warning text-dark border border-warning">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('booking.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pengajuan sewa ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        Batalkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted mb-3">
                                    <i class="bi bi-clipboard-x display-4"></i> </div>
                                <h5 class="text-muted">Belum ada pesanan</h5>
                                <p class="text-muted small">Cari kos impianmu sekarang juga.</p>
                                <a href="{{ url('/') }}" class="btn btn-primary btn-sm mt-2">Cari Kos Sekarang</a>
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