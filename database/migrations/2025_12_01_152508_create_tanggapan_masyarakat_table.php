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
        Schema::create('tanggapan_masyarakat', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel KNMP
            $table->foreignId('knmp_id')
                ->constrained('knmp')
                ->onDelete('cascade');

            // Pertanyaan 1
            $table->boolean('kesesuaian_kebutuhan');
            // TRUE  = Ya, sesuai
            // FALSE = Tidak sesuai

            // Pertanyaan 2 (boleh NULL)
            $table->text('item_tidak_sesuai')->nullable();

            // Pertanyaan 3
            $table->string('tingkat_kesenangan', 50);
            // Contoh: Senang, Biasa saja, Tidak Senang

            // Pertanyaan 4 (boleh NULL)
            $table->text('alasan_tidak_senang')->nullable();

            // Pertanyaan tambahan (opsional)
            $table->text('harapan_masyarakat')->nullable();
            $table->text('masukan_saran_perbaikan')->nullable();

            $table->timestamps();

            // Optional index untuk performa
            $table->index('knmp_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggapan_masyarakat');
    }
};
