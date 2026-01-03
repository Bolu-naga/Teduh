<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // 1. FUNGSI MENGAJUKAN SEWA
    public function store(Request $request, $id)
    {
        // Validasi tanggal
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
        ]);

        // Cek apakah user sudah pernah booking kos ini dan statusnya belum selesai/batal
        $existingBooking = Booking::where('user_id', Auth::id())
                                ->where('kos_id', $id)
                                ->where('status', 'pending')
                                ->first();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan sewa untuk kos ini sebelumnya.');
        }

        // Simpan ke Database
        Booking::create([
            'user_id'       => Auth::id(),
            'kos_id'        => $id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'status'        => 'pending', // Status awal: Menunggu Konfirmasi
        ]);

        // Redirect ke halaman "Pesanan Saya"
        return redirect()->route('my.bookings')->with('success', 'Pengajuan sewa berhasil dikirim! Tunggu konfirmasi pemilik.');
    }

    // 2. FUNGSI LIHAT DAFTAR PESANAN SAYA (CUSTOMER)
    public function indexSaya()
    {
        $bookings = Booking::with('kos')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('booking.customer', compact('bookings'));
    }

    // 3. FUNGSI BATALKAN PESANAN
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        // Keamanan: Pastikan yang menghapus adalah pemilik booking
        if ($booking->user_id != Auth::id()) {
            abort(403, 'Anda tidak berhak membatalkan pesanan ini.');
        }

        $booking->delete();

        return redirect()->back()->with('success', 'Pengajuan sewa berhasil dibatalkan.');
    }

// 4. FUNGSI UNTUK PEMILIK KOS (LIHAT PESANAN MASUK)
    public function indexMilikSaya()
    {
        // Cari semua booking dimana 'kos' yang dipesan adalah milik user yang sedang login
        $pesanan = Booking::whereHas('kos', function($query) {
            $query->where('user_id', Auth::id());
        })->with(['kos', 'user']) 
          ->latest()
          ->get();

        return view('booking.masuk', compact('pesanan'));
    }
}