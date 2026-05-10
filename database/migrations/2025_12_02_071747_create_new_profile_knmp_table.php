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
        if (!Schema::hasTable('profile_knmp')) {
            Schema::create('profile_knmp', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('knmp_id')->nullable(); // ID relasi atau referensi eksternal

                // 1-5. Data Utama Profil
                $table->integer('jml_penduduk_des')->nullable();
                $table->integer('jml_nelayan')->nullable();
                $table->bigInteger('pendapatan_rata_rata_nelayan')->nullable();
                $table->bigInteger('volume_produksi_ton')->nullable();
                $table->decimal('nilai_produksi', 15, 2)->nullable();

                // 6-7. Komoditas dan Harga
                $table->string('komoditas_utama_1', 255)->nullable();
                $table->string('komoditas_utama_2', 255)->nullable();
                $table->bigInteger('harga_rata_komoditas_1')->nullable(); // Harga rata-rata ikan (Rp)
                $table->bigInteger('harga_rata_komoditas_2')->nullable(); // Harga rata-rata ikan (Rp)

                // 8. Ketersediaan Infrastruktur Pendukung (Boolean: TRUE=Ada, FALSE=Tidak Ada)
                $table->boolean('infra_jalan_akses')->nullable();
                $table->boolean('infra_listrik')->nullable();
                $table->boolean('infra_air_bersih')->nullable();
                $table->boolean('infra_internet')->nullable();
                $table->boolean('infra_ipal')->nullable();
                $table->boolean('infra_dermaga_tambat')->nullable();
                $table->boolean('infra_tpi')->nullable();
                $table->boolean('infra_cold_storage')->nullable();
                $table->boolean('infra_pabrik_es')->nullable();
                $table->boolean('infra_kantor_koperasi')->nullable();
                $table->boolean('infra_bengkel_nelayan')->nullable();
                $table->boolean('infra_waserda')->nullable();

                // 9-13. Data Koperasi (Disinkronkan dengan input HTML dan kuesioner lama)
                $table->string('calon_koperasi', 255)->nullable();
                $table->string('nama_ketua', 255)->nullable();
                $table->string('sk_kopdeskel', 255)->nullable();
                $table->string('nomor_induk_kopdeskel', 255)->nullable();
                $table->integer('jumlah_anggota_laki')->nullable();
                $table->integer('jumlah_anggota_perempuan')->nullable();

                // 14. Lokasi
                $table->string('koordinat_lokasi', 255)->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_knmp');
    }
};
