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
            $table->unsignedBigInteger('knmp_id')->nullable();
            $table->unsignedBigInteger('responden_id')->nullable();
            $table->integer('nomor_soal')->nullable();
            $table->string('kategori')->nullable();
            $table->string('jawaban_teks')->nullable();
            $table->integer('skor_nilai')->nullable();
            $table->timestamps();

            $table->foreign('knmp_id')
                ->references('id')
                ->on('knmp')
                ->onDelete('cascade');
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
