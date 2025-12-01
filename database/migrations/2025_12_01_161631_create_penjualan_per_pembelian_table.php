<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan_per_pembelian', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel informasi_pemasaran
            $table->foreignId('pemasaran_id')->constrained('informasi_pemasaran')->onDelete('cascade');

            $table->string('jenis_pemasaran', 100); // Contoh: Koperasi, Tengkulak, Pedagang Besar
            $table->float('total_penjualan_kg_per_trip')->default(0);

            $table->timestamps();

            // Menjamin kombinasi pemasaran dan id pemasaran unik (agar tidak ada duplikasi data jenis pemasaran untuk satu trip)
            $table->unique(['pemasaran_id', 'jenis_pemasaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_per_pembelian');
    }
};
