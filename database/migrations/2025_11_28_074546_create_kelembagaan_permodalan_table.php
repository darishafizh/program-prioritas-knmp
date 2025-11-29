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
        Schema::create('kelembagaan_permodalan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('knmp')->cascadeOnDelete();
            $table->string('jenis_usaha_aset', 100);
            $table->char('sumber_permodalan_kode', 1)->nullable();
            $table->string('nama_lembaga_pinjaman', 100)->nullable();
            $table->text('rencana_permodalan_kopdeskel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelembagaan_permodalan');
    }
};
