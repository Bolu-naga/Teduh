<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KosController;

// 1. Halaman Utama (Bisa diakses siapa saja, tanpa login)
Route::get('/', [KosController::class, 'index'])->name('home');

// 2. Grup Khusus Pemilik Kos (Wajib Login dulu)
Route::middleware(['auth'])->group(function () {
    // Menampilkan form tambah kos
    Route::get('/kos/create', [KosController::class, 'create'])->name('kos.create');
    
    // Menyimpan data kos ke database
    Route::post('/kos', [KosController::class, 'store'])->name('kos.store');
    
    // Menghapus data kos
    Route::delete('/kos/{id}', [KosController::class, 'destroy'])->name('kos.destroy');
});

// Ini bawaan Laravel Breeze (Login/Register)
require __DIR__.'/auth.php';