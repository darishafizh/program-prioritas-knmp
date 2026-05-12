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
        // 1. Hapus kolom nama_jasa_konstruksi di progres_harian
        Schema::table('progres_harian', function (Blueprint $table) {
            if (Schema::hasColumn('progres_harian', 'nama_jasa_konstruksi')) {
                $table->dropColumn('nama_jasa_konstruksi');
            }
        });

        // 2. Tambahkan kolom jasa_konstruksi_id di tahap_konstruksi (jika belum ada)
        Schema::table('tahap_konstruksi', function (Blueprint $table) {
            if (!Schema::hasColumn('tahap_konstruksi', 'jasa_konstruksi_id')) {
                $table->unsignedBigInteger('jasa_konstruksi_id')->nullable()->after('knmp_id');
                $table->foreign('jasa_konstruksi_id')->references('id')->on('penyedia_jasa_konstruksi')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progres_harian', function (Blueprint $table) {
            $table->string('nama_jasa_konstruksi')->nullable()->after('progres');
        });

        Schema::table('tahap_konstruksi', function (Blueprint $table) {
            if (Schema::hasColumn('tahap_konstruksi', 'jasa_konstruksi_id')) {
                $table->dropForeign(['jasa_konstruksi_id']);
                $table->dropColumn('jasa_konstruksi_id');
            }
        });
    }
};
