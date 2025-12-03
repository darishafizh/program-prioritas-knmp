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
        Schema::create('detail_komponen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('profile_knmp')->onDelete('cascade');

            $table->string('jenis_komponen', 255);
            $table->integer('target_unit')->nullable();
            $table->decimal('progress_persen', 5, 2)->nullable(); // Menggunakan Progress (%) dari kuesioner
            $table->bigInteger('anggaran')->nullable(); // Anggaran (Rp)
            $table->bigInteger('realisasi_anggaran')->nullable();
            $table->decimal('persen_realisasi_anggaran', 5, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_komponen');
    }
};
