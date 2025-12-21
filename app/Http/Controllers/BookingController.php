<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // 1. (Customer) Proses Pesan Kos
    public function store(Request $request, $id)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'kos_id' => $id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'status' => 'menunggu_konfirmasi'
        ]);

        return redirect('/')->with('success', 'Permintaan sewa berhasil dikirim ke pemilik!');
    }

    // 2. (Pemilik) Lihat Daftar Pesanan Masuk
    public function indexMilikSaya()
    {
        // Ambil semua kos milik user yang login
        $kos_milik_saya = Kos::where('user_id', Auth::id())->pluck('id');

        // Ambil booking yang kos_id nya ada di daftar kos saya
        $pesanan = Booking::with(['user', 'kos'])
                    ->whereIn('kos_id', $kos_milik_saya)
                    ->latest()
                    ->get();

        return view('booking.masuk', compact('pesanan'));
    }

    // 3. (Customer) Lihat Riwayat Pesanan Sendiri
    public function indexSaya()
    {
        $pesanan = Booking::with('kos')->where('user_id', Auth::id())->latest()->get();
        return view('booking.saya', compact('pesanan'));
    }
}