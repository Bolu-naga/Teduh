<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    protected $guarded=[];

    // Relasi: Booking milik satu User (Customer)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi: Booking untuk satu Kos
    public function kos() {
        return $this->belongsTo(Kos::class);
    }
}
