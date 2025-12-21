<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KosController extends Controller
{
    // 1. HALAMAN DEPAN (Menampilkan Kos + Fitur Cari)
    public function index(Request $request)
    {
        $query = Kos::query();

        // Jika ada pencarian
        if ($request->has('search')) {
            $query->where('nama_kos', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%');
        }

        // Ambil data terbaru
        $data_kos = $query->latest()->get();
        
        return view('kos.index', compact('data_kos'));
    }

    // 2. HALAMAN FORM TAMBAH KOS
    public function create()
    {
        return view('kos.create');
    }

    // 3. PROSES SIMPAN DATA (Ke Database)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kos' => 'required',
            'harga' => 'required|numeric',
            'lokasi' => 'required',
            'no_hp' => 'required',
            'gambar' => 'image|file|max:5048' // Maksimal 5MB
        ]);

        // Proses Upload Gambar
        $path_gambar = null;
        if ($request->file('gambar')) {
            $path_gambar = $request->file('gambar')->store('foto-kos', 'public');
        }

        // Simpan ke Database
        Kos::create([
            'user_id' => Auth::id(), // ID user yang sedang login
            'nama_kos' => $request->nama_kos,
            'lokasi' => $request->lokasi,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi ?? '-', // Kalau kosong diisi strip
            'no_hp' => $request->no_hp,
            'gambar' => $path_gambar
        ]);

        return redirect('/')->with('success', 'Kos berhasil ditambahkan!');
    }

    // 4. PROSES HAPUS DATA
    public function destroy($id)
    {
        $kos = Kos::findOrFail($id);

        // Cek apakah yang menghapus adalah pemilik aslinya?
        if ($kos->user_id != Auth::id()) {
            abort(403, 'Anda tidak punya hak menghapus kos ini');
        }

        // Hapus gambar lama jika ada
        if ($kos->gambar) {
            Storage::delete('public/' . $kos->gambar);
        }

        $kos->delete();

        return redirect('/')->with('success', 'Data kos berhasil dihapus.');
    }
}