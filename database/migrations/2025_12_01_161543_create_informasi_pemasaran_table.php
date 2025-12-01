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
        Schema::create('informasi_pemasaran', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel wawancara
            $table->foreignId('wawancara_id')->constrained('wawancara')->onDelete('cascade')->unique();

            // Jawaban Pertanyaan No. 2
            $table->boolean('terdapat_kendala_pemasaran')->default(false);
            $table->text('penjelasan_kendala_pemasaran')->nullable();

            // Jawaban Pertanyaan No. 3
            $table->text('cara_penanganan_ikan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_pemasaran');
    }
};
