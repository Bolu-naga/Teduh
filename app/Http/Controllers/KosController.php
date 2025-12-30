<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\KosImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KosController extends Controller
{
    // 1. TAMPILKAN HALAMAN DEPAN
    public function index(Request $request)
    {
        $query = Kos::query();
        if ($request->has('search')) {
            $query->where('nama_kos', 'like', '%' . $request->search . '%');
        }
        $data_kos = $query->latest()->get();
        return view('kos.index', compact('data_kos'));
    }

    // 2. HALAMAN FORM TAMBAH
    public function create()
    {
        return view('kos.create');
    }

    // 3. PROSES SIMPAN DATA (CREATE)
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_kos' => 'required',
            'lokasi'    => 'required',
            'harga'   => 'required|numeric',
            'deskripsi' => 'required',
            'no_hp'    => 'required', 
            'gambar' => 'required|image|mimes:jpeg,png,jpg', // Foto Galeri Tambahan
        ]);

        $input = $request->all();
        
        // --- Masukkan ID User yang sedang login ---
        $input['user_id'] = Auth::id(); 
        // ----------------------------------------------------

        // Upload Foto Utama
        if ($image = $request->file('gambar')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move(public_path($destinationPath), $profileImage);
            $input['gambar'] = "$profileImage";
        }

        unset($input['image']);

        $kos = Kos::create($input);

        // Upload Galeri Foto Tambahan
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $name = date('YmdHis') . uniqid() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('images/gallery/'), $name);

                KosImage::create([
                    'kos_id' => $kos->id,
                    'image_path' => $name
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'Kos berhasil ditambahkan!');
    }

    // 4. HALAMAN EDIT
    public function edit($id)
    {
        $kos = Kos::findOrFail($id);
        
        // Cek Pemilik
        if ($kos->user_id != Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit kos ini');
        }

        return view('kos.edit', compact('kos'));
    }

    // 5. PROSES UPDATE
    public function update(Request $request, $id)
    {
        $kos = Kos::findOrFail($id);

        // Cek Pemilik
        if ($kos->user_id != Auth::id()) {
            abort(403, 'Anda tidak punya hak mengedit kos ini');
        }

        // 1. VALIDASI
        $request->validate([
            'nama_kos' => 'required',
            'lokasi'    => 'required',
            'harga'   => 'required|numeric',
            'deskripsi' => 'required',
            'no_hp'    => 'required', 
            'gambar' => 'required|image|mimes:jpeg,png,jpg', // update
        ]);

        $input = $request->all();

        // 2. LOGIKA UPDATE FOTO COVER (name='gambar')
        if ($image = $request->file('gambar')) {
            
            // Hapus file lama fisik jika ada
            if ($kos->gambar && file_exists(public_path('images/' . $kos->gambar))) {
                unlink(public_path('images/' . $kos->gambar));
            }

            // Upload file baru
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move(public_path($destinationPath), $profileImage);
            
            // Masukkan nama file baru ke array input untuk diupdate ke DB
            $input['gambar'] = $profileImage;
        } else {
            // Jika tidak upload gambar baru, hapus key 'gambar' dari input
            unset($input['gambar']);
        }

        // 3. PROSES UPDATE DATABASE
        $kos->update($input);

        // 4. LOGIKA TAMBAH FOTO GALERI (name='photos')
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $name = date('YmdHis') . uniqid() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('images/gallery/'), $name);

                KosImage::create([
                    'kos_id' => $kos->id,
                    'image_path' => $name
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'Data kos berhasil diperbarui');
    }
    
    // 6. DELETE (Opsional, jika ada error delete)
    public function destroy($id)
    {
        $kos = Kos::findOrFail($id);
        if ($kos->user_id != Auth::id()) abort(403);
        $kos->delete();
        return redirect()->route('home')->with('success', 'Kos berhasil dihapus');
    }
}