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
        Schema::create('informasi_pendapatan_rumah_tangga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('knmp_id');
            $table->foreign('knmp_id')->references('id')->on('knmp')->onDelete('cascade');

            $table->decimal('pendapatan_perikanan', 15, 2)->nullable();
            $table->decimal('pendapatan_non_perikanan', 15, 2)->nullable();
            $table->decimal('pendapatan_total', 15, 2)->nullable();

            $table->string('kontribusi_nelayan_persen')->nullable();
            $table->string('jumlah_sumber_penghasilan')->nullable();
            $table->string('ketergantungan_perikanan')->nullable();
            $table->string('stabilitas_pendapatan')->nullable();
            $table->string('keterlibatan_perempuan')->nullable();
            $table->string('kontribusi_perempuan_persen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_pendapatan_rumah_tangga');
    }
};
