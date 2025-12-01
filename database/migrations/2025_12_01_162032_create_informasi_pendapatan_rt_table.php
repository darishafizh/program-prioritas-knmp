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
        Schema::create('informasi_pendapatan_rt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wawancara_id')->constrained('wawancara')->onDelete('cascade')->unique();

            $table->bigInteger('pendapatan_perikanan_per_bulan')->nullable();
            $table->bigInteger('pendapatan_luar_perikanan_per_bulan')->nullable();

            $table->string('persentase_kontribusi_nelayan', 50);
            $table->string('jumlah_sumber_penghasilan', 50);
            $table->string('tingkat_ketergantungan', 50);
            $table->string('tingkat_stabilitas_pendapatan', 50);
            $table->string('keterlibatan_perempuan_ekonomi', 50);
            $table->string('kontribusi_perempuan_pendapatan', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_pendapatan_rt');
    }
};
