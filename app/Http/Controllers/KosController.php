<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\KosImage; // Pastikan Model ini di-import
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
        // Validasi (Sesuai kode Anda)
        $request->validate([
            'nama_kos'  => 'required',
            'lokasi'    => 'required',
            'harga'     => 'required|numeric',
            'deskripsi' => 'required',
            'no_hp'     => 'required', 
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg',
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

        // Membersihkan inputan sisa (jika ada input name='image' di form)
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
            'nama_kos'  => 'required',
            'lokasi'    => 'required',
            'harga'     => 'required|numeric',
            'deskripsi' => 'required',
            'no_hp'     => 'required', 
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg', 
        ]);

        $input = $request->all();

        // --- FITUR BARU: HAPUS FOTO GALERI YANG DICENTANG ---
        // Logika ini menangkap checkbox dari view edit.blade.php
        if ($request->has('delete_photos')) {
            $photosToDeleteIds = $request->input('delete_photos');
            
            // Ambil data foto dari database berdasarkan ID dan pastikan milik kos ini
            $photosToDelete = KosImage::whereIn('id', $photosToDeleteIds)
                                        ->where('kos_id', $kos->id) 
                                        ->get();

            foreach ($photosToDelete as $photo) {
                // 1. Hapus file fisik dari folder server
                if (file_exists(public_path('images/gallery/' . $photo->image_path))) {
                    unlink(public_path('images/gallery/' . $photo->image_path));
                }
                // 2. Hapus record dari database
                $photo->delete();
            }
        }
        // ----------------------------------------------------

        // 2. LOGIKA UPDATE FOTO COVER 
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

        // 4. LOGIKA TAMBAH FOTO GALERI 
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
    
    // 6. DELETE
    public function destroy($id)
    {
        $kos = Kos::findOrFail($id);
        
        if ($kos->user_id != Auth::id()) abort(403);

        // Hapus file cover fisik
        if ($kos->gambar && file_exists(public_path('images/' . $kos->gambar))) {
            unlink(public_path('images/' . $kos->gambar));
        }

        foreach($kos->images as $img) {
            if (file_exists(public_path('images/gallery/' . $img->image_path))) {
                unlink(public_path('images/gallery/' . $img->image_path));
            }
        }

        $kos->delete();
        return redirect()->route('home')->with('success', 'Kos berhasil dihapus');
    }
}