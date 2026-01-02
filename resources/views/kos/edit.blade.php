@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Data Kos</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('kos.update', $kos->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_kos" class="form-label">Nama Kos</label>
                            <input type="text" name="nama_kos" class="form-control"
                                value="{{ old('nama_kos', $kos->nama_kos) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control"
                                value="{{ old('lokasi', $kos->lokasi) }}" placeholder="Contoh: Jakarta Selatan">
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga (Per Bulan)</label>
                            <input type="number" name="harga" class="form-control"
                                value="{{ old('harga', $kos->harga) }}">
                        </div>

                        <div class="mb-3">
                            <label for='no_hp' class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control"
                                value="{{ old('no_hp', $kos->no_hp) }}">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Lengkap</label>
                            <textarea name="deskripsi" class="form-control"
                                rows="4">{{ old('deskripsi', $kos->deskripsi) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Utama (Thumbnail)</label>
                            <br>
                            @if($kos->gambar)
                            <img src="{{ asset('images/' . $kos->gambar) }}" alt="Foto Lama" width="150"
                                class="img-thumbnail mb-2">
                            <p class="text-muted small">Gambar saat ini. Upload baru jika ingin mengganti.</p>
                            + @endif
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-4 border p-3 rounded bg-light">
                            <label class="form-label fw-bold h6 mb-3">Kelola Galeri Foto Detail</label>

                            @if($kos->images->count() > 0)
                            <p class="small text-muted mb-2">Centang pada kotak "Hapus" di bawah foto yang ingin
                                dibuang, lalu klik tombol Update Data.</p>
                            <div class="row mb-3">
                                @foreach($kos->images as $img)
                                <div class="col-6 col-md-3 mb-3 text-center">
                                    <div class="card h-100">
                                        <img src="{{ asset('images/gallery/' . $img->image_path) }}"
                                            class="card-img-top img-thumbnail" style="height: 120px; object-fit: cover;"
                                            alt="Galeri">
                                        <div class="card-body p-2 bg-white">
                                            <div
                                                class="form-check d-flex justify-content-center align-items-center bg-danger-subtle p-1 rounded border border-danger">
                                                <input class="form-check-input me-2" type="checkbox"
                                                    name="delete_photos[]" value="{{ $img->id }}" id="del{{ $img->id }}"
                                                    style="cursor: pointer;">
                                                <label class="form-check-label text-danger fw-bold small"
                                                    for="del{{ $img->id }}" style="cursor: pointer;">
                                                    Hapus Foto Ini
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="small text-muted fst-italic">Belum ada foto galeri tambahan.</p>
                            @endif

                            <div class="mt-3">
                                <label class="form-label fw-bold">Tambah Foto Baru ke Galeri</label>
                                <input type="file" name="photos[]" class="form-control" multiple accept="image/*">
                                <small class="text-muted">Pilih foto-foto baru untuk ditambahkan. Foto yang dicentang
                                    "Hapus" di atas akan hilang.</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update Data</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
