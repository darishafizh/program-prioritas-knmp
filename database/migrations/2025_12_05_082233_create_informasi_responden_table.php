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
        Schema::create('informasi_responden', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('knmp_id')->index();

            $table->string('nama_responden')->nullable();
            $table->string('nik', 20)->nullable();
            $table->string('nomor_kusuka', 30)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->unsignedSmallInteger('umur')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('suku_bangsa')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('wpp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_hp_responden', 20)->nullable();

            $table->unsignedSmallInteger('jumlah_anggota_rumah')->nullable();
            $table->unsignedSmallInteger('jumlah_anggota_perempuan_rumah')->nullable();
            $table->unsignedSmallInteger('jumlah_anggota_bekerja')->nullable();
            $table->unsignedSmallInteger('jumlah_anggota_perempuan_bekerja')->nullable();

            $table->unsignedSmallInteger('jumlah_abk')->nullable();

            $table->unsignedSmallInteger('pengalaman_usaha')->nullable();

            $table->unsignedBigInteger('province_id')->nullable()->index();
            $table->unsignedBigInteger('regency_id')->nullable()->index();
            $table->unsignedBigInteger('district_id')->nullable()->index();
            $table->unsignedBigInteger('village_id')->nullable()->index();

            $table->date('tanggal_wawancara')->nullable();
            $table->string('nama_enumerator')->nullable();
            $table->enum('jenis_kelamin_enumerator', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('no_hp_enumerator', 20)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_responden');
    }
};
