@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Data Kos Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('kos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kos</label>
                        <input type="text" name="nama_kos" class="form-control" placeholder="Contoh: Kos Melati Indah" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga per Bulan (Rp)</label>
                            <input type="number" name="harga" class="form-control" placeholder="Contoh: 500000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nomor WhatsApp</label>
                            <input type="number" name="no_hp" class="form-control" placeholder="Contoh: 62812345678" required>
                            <small class="text-muted">Gunakan format 628xxx (tanpa + atau 0)</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi (Kecamatan/Kota)</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Denpasar Selatan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Fasilitas</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Contoh: Ada Wifi, kamar mandi dalam, parkir luas..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Kos (Opsional)</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Kos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection