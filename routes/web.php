<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KosController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN UTAMA (Bisa diakses siapa saja)
Route::get('/', [KosController::class, 'index'])->name('home');

// 2. DASHBOARD (Hanya redirect ke home setelah login)
Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. GRUP RUTE KHUSUS YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {
    
    // --- FITUR KOS (CRUD) ---
    // Form Tambah Kos
    Route::get('/kos/create', [KosController::class, 'create'])->name('kos.create');
    // Proses Simpan Kos
    Route::post('/kos', [KosController::class, 'store'])->name('kos.store');
    // Form Edit Kos
    Route::get('/kos/{id}/edit', [KosController::class, 'edit'])->name('kos.edit');
    // Proses Update Kos
    Route::put('/kos/{id}', [KosController::class, 'update'])->name('kos.update');
    // Proses Hapus Kos
    Route::delete('/kos/{id}', [KosController::class, 'destroy'])->name('kos.destroy');

    // --- FITUR BOOKING (PEMESANAN) ---
    // Customer: Melakukan Booking
    Route::post('/booking/{id}', [BookingController::class, 'store'])->name('booking.store');
    
    // Customer: Lihat Pesanan Saya 
    Route::get('/pesanan-saya', [BookingController::class, 'indexSaya'])->name('my.bookings');

    // Customer: Batalkan Pesanan
    Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
    
    // Pemilik: Lihat Pesanan Masuk
    Route::get('/pesanan-masuk', [BookingController::class, 'indexMilikSaya'])->name('owner.bookings');

    // --- PROFIL USER (Bawaan Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load file auth.php (Login/Register/Logout)
require __DIR__.'/auth.php';