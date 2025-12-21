<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang pesan (Customer)
        $table->foreignId('kos_id')->constrained('kos')->onDelete('cascade'); // Kos mana yang dipesan
        $table->string('status')->default('menunggu_konfirmasi'); // Status pesanan
        $table->date('tanggal_mulai'); // Kapan mau masuk
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
