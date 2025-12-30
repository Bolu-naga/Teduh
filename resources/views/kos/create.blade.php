@extends('layout')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Data Kos Baru</h5>
                </div>
                <div class="card-body">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Kos</label>
                            <input type="text" name="nama_kos" class="form-control" placeholder="Contoh: Kos Melati" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga per Bulan (Rp)</label>
                                <input type="number" name="harga" class="form-control" placeholder="Contoh: 1500000" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor WhatsApp</label>
                                <input type="text" name="no_hp" class="form-control" placeholder="628xxxxxxx" required>
                                <small class="text-muted">Gunakan awalan 62 (tanpa + atau 0)</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi (Kecamatan/Kota)</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Denpasar Selatan" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Fasilitas</label>
                            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan fasilitas: WiFi, AC, Parkir, dll."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Cover Depan (Wajib)</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Detail Tambahan (Kamar, WC, Dapur)</label>
                            <input type="file" name="photos[]" class="form-control" multiple accept="image/*">
                            <small class="text-muted">Bisa pilih lebih dari satu foto sekaligus.</small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('home') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Kos</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection