<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    use HasFactory;

    protected $table = 'kos'; 
    protected $fillable = [
        'user_id',      // Penting: ID pemilik kos
        'nama_kos',
        'lokasi',
        'harga',
        'deskripsi',
        'no_hp',     
        'gambar',     
        'created_at',
        'updated_at',
    ];

    // Relasi ke User (Pemilik)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function images()
    {
        return $this->hasMany(KosImage::class, 'kos_id');
    }
}