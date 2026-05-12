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
        // 1. Hapus tabel tahap_konstruksi yang lama
        Schema::dropIfExists('tahap_konstruksi');

        // 2. Rename timeline_pengerjaan menjadi tahap_konstruksi
        Schema::rename('timeline_pengerjaan', 'tahap_konstruksi');

        // 3. Tambahkan kolom jasa_konstruksi_id ke tabel tahap_konstruksi yang baru
        Schema::table('tahap_konstruksi', function (Blueprint $table) {
            if (!Schema::hasColumn('tahap_konstruksi', 'jasa_konstruksi_id')) {
                $table->unsignedBigInteger('jasa_konstruksi_id')->nullable()->after('knmp_id');
                $table->foreign('jasa_konstruksi_id')
                    ->references('id')
                    ->on('penyedia_jasa_konstruksi')
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse rename: rename back to timeline_pengerjaan
        Schema::rename('tahap_konstruksi', 'timeline_pengerjaan');

        // Recreate the separate tahap_konstruksi table if needed
        Schema::create('tahap_konstruksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('knmp_id');
            $table->unsignedBigInteger('jasa_konstruksi_id')->nullable();
            $table->integer('periode_mingguan')->nullable();
            $table->decimal('bobot_rencana_kumulatif', 8, 2)->nullable();
            $table->decimal('bobot_realisasi_kumulatif', 8, 2)->nullable();
            $table->timestamps();
        });
    }
};
