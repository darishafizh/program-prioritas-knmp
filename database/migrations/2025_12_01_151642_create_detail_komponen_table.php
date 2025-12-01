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
            $table->foreignId('knmp_id')->constrained('knmp')->onDelete('cascade');
            $table->string('jenis_komponen', 255);
            $table->integer('target_unit');
            $table->integer('realisasi_unit')->default(0);
            $table->decimal('persentase_realisasi', 5, 2)->default(0.00);
            $table->bigInteger('anggaran');
            $table->bigInteger('realisasi_anggaran')->default(0);
            $table->decimal('persentase_realisasi_anggaran', 5, 2)->default(0.00);
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
