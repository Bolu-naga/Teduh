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
        Schema::create('kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menyimpan ID pemilik kos
            $table->string('nama_kos');
            $table->string('lokasi');
            $table->integer('harga');
            $table->text('deskripsi');
            $table->string('no_hp'); 
            $table->string('gambar')->nullable(); // Foto boleh kosong
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kos');
    }
};
