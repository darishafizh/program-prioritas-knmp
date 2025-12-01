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
        Schema::create('responden', function (Blueprint $table) {
            $table->string('nik', 30)->primary(); // Primary Key
            $table->string('nama', 150);
            $table->string('nomor_kusuka', 50)->nullable();
            $table->integer('umur');
            $table->string('tempat_tanggal_lahir', 200);
            $table->string('jenis_kelamin', 20);
            $table->string('suku_bangsa', 50);
            $table->string('pendidikan_terakhir', 50);
            $table->integer('jumlah_abk_kapal');
            $table->integer('pengalaman_usaha_tahun');
            $table->string('wpp_penangkapan_ikan', 100)->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->date('tanggal_wawancara');
            $table->foreignId('lokasi_id')->constrained('lokasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responden');
    }
};
