<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    use HasFactory;

    // Ini kuncinya: Membolehkan kita menyimpan data ke semua kolom
    protected $guarded = [];

    public function bookings() {
    return $this->hasMany(Booking::class);
}
}
