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
        Schema::create('tingkat_kebahagiaan_nelayan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('profile_knmp')->onDelete('cascade');
            $table->integer('nomor_soal');
            $table->string('kategori', 50);
            $table->string('jawaban_teks', 50);
            $table->integer('skor_nilai');
            $table->unique(['knmp_id', 'nomor_soal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tingkat_kebahagiaan_nelayan');
    }
};
