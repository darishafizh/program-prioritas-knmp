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
        Schema::create('knmp_konstruksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('knmp');
            $table->foreignId('konstruksi_id')->constrained('penyedia_jasa_konstruksi');
            $table->enum('peran', ['utama', 'pendamping']);
            $table->timestamps();
        });

        Schema::create('riwayat_tahap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('knmp');
            $table->string('tahap_dari')->nullable();
            $table->string('tahap_ke');
            $table->text('keterangan')->nullable();
            $table->uuid('batch_id')->nullable()->index();
            $table->string('created_by')->nullable();
            $table->timestamps();
            
            $table->index('knmp_id');
        });

        Schema::create('tahap_usulan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->unique()->constrained('knmp');
            $table->date('tanggal')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('tahap_survey', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->unique()->constrained('knmp');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->date('tanggal')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('tahap_ded', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->unique()->constrained('knmp');
            $table->string('nomor_dokumen');
            $table->date('tanggal_pengesahan')->nullable();
            $table->text('file_url')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('tahap_lelang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->unique()->constrained('knmp');
            $table->string('nomor_paket');
            $table->decimal('nilai_hps', 15, 2)->nullable();
            $table->decimal('nilai_kontrak', 15, 2)->nullable();
            $table->date('tanggal_penetapan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('tahap_serah_terima', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->unique()->constrained('knmp');
            $table->string('nomor_kontrak');
            $table->decimal('nilai_kontrak', 15, 2)->nullable();
            $table->date('tanggal_serah')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('progres_harian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('knmp');
            $table->date('tanggal');
            $table->decimal('progres', 5, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->index(['knmp_id', 'tanggal']);
        });

        Schema::create('dokumentasi_konstruksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('knmp');
            $table->date('tanggal')->nullable();
            $table->enum('jenis_foto', ['progress', 'kondisi', 'selesai'])->nullable();
            $table->text('file_url');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->index('knmp_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_konstruksi');
        Schema::dropIfExists('progres_harian');
        Schema::dropIfExists('tahap_serah_terima');
        Schema::dropIfExists('tahap_lelang');
        Schema::dropIfExists('tahap_ded');
        Schema::dropIfExists('tahap_survey');
        Schema::dropIfExists('tahap_usulan');
        Schema::dropIfExists('riwayat_tahap');
        Schema::dropIfExists('knmp_konstruksi');
    }
};
