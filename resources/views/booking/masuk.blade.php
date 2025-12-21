@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">📦 Pesanan Masuk</h2>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Pemesan</th>
                                <th>Kos yang Dipesan</th>
                                <th>Rencana Masuk</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesanan as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->user->name }}</strong><br>
                                    <small class="text-muted">{{ $item->user->email }}</small>
                                </td>
                                <td>{{ $item->kos->nama_kos }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm">
                                        Hubungi Pemesan
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada pesanan masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection