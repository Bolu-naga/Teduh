<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings'; 
    protected $fillable = [
        'user_id',
        'kos_id',
        'tanggal_mulai',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kos
    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
}