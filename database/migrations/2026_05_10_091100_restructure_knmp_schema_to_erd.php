<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Restructure the entire KNMP schema to match the new ERD.
     */
    public function up(): void
    {
        // =============================================
        // 1. Create `batch` table (master/referensi)
        // =============================================
        Schema::create('batch', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tahap');
            $table->year('tahun');
            $table->timestamps();
        });

        // =============================================
        // 2. Modify `knmp` table
        //    - Add batch_id FK
        //    - Rename tahap -> tahap_saat_ini (enum)
        //    - Rename kabupaten_kota -> kabupaten
        //    - Rename desa_kelurahan -> desa
        //    - Drop tanggal_mulai
        // =============================================
        Schema::table('knmp', function (Blueprint $table) {
            // Add batch_id
            $table->unsignedBigInteger('batch_id')->nullable()->after('id');
            $table->foreign('batch_id')->references('id')->on('batch')->nullOnDelete();
        });

        // Rename columns
        Schema::table('knmp', function (Blueprint $table) {
            $table->renameColumn('kabupaten_kota', 'kabupaten');
        });
        Schema::table('knmp', function (Blueprint $table) {
            $table->renameColumn('desa_kelurahan', 'desa');
        });

        // Handle tahap -> tahap_saat_ini rename + enum conversion
        // First add the new column
        Schema::table('knmp', function (Blueprint $table) {
            $table->string('tahap_saat_ini')->nullable()->after('batch_id');
        });

        // Copy data from old column
        DB::statement("UPDATE knmp SET tahap_saat_ini = tahap");

        // Drop old column
        Schema::table('knmp', function (Blueprint $table) {
            $table->dropColumn('tahap');
        });

        // Drop tanggal_mulai if exists
        if (Schema::hasColumn('knmp', 'tanggal_mulai')) {
            Schema::table('knmp', function (Blueprint $table) {
                $table->dropColumn('tanggal_mulai');
            });
        }

        // =============================================
        // 3. Simplify `tahap_survey`
        //    Remove latitude, longitude (moved to knmp)
        // =============================================
        Schema::table('tahap_survey', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });

        // =============================================
        // 4. Simplify `tahap_lelang`
        //    Remove nomor_paket, nilai_hps, nilai_kontrak
        // =============================================
        Schema::table('tahap_lelang', function (Blueprint $table) {
            $table->dropColumn(['nomor_paket', 'nilai_hps', 'nilai_kontrak']);
        });

        // =============================================
        // 5. Simplify `tahap_serah_terima`
        //    Remove nilai_kontrak
        // =============================================
        Schema::table('tahap_serah_terima', function (Blueprint $table) {
            $table->dropColumn('nilai_kontrak');
        });

        // =============================================
        // 6. Create `tahap_konstruksi` (replaces knmp_konstruksi)
        // =============================================
        Schema::create('tahap_konstruksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('knmp_id');
            $table->foreign('knmp_id')->references('id')->on('knmp')->cascadeOnDelete();
            $table->unsignedBigInteger('jasa_konstruksi_id')->nullable();
            $table->foreign('jasa_konstruksi_id')->references('id')->on('penyedia_jasa_konstruksi')->nullOnDelete();
            $table->integer('periode_mingguan')->nullable();
            $table->decimal('bobot_rencana_kumulatif', 8, 2)->nullable();
            $table->decimal('bobot_realisasi_kumulatif', 8, 2)->nullable();
            $table->timestamps();
        });

        // =============================================
        // 7. Simplify `progres_harian`
        //    Remove keterangan
        // =============================================
        if (Schema::hasColumn('progres_harian', 'keterangan')) {
            Schema::table('progres_harian', function (Blueprint $table) {
                $table->dropColumn('keterangan');
            });
        }

        // =============================================
        // 8. Simplify `riwayat_tahap`
        //    Remove batch_id (uuid), created_by
        // =============================================
        Schema::table('riwayat_tahap', function (Blueprint $table) {
            // Drop index first if it exists
            if (Schema::hasColumn('riwayat_tahap', 'batch_id')) {
                $table->dropIndex(['batch_id']);
            }
        });
        Schema::table('riwayat_tahap', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('riwayat_tahap', 'batch_id')) {
                $columns[] = 'batch_id';
            }
            if (Schema::hasColumn('riwayat_tahap', 'created_by')) {
                $columns[] = 'created_by';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });

        // =============================================
        // 9. Drop old tables no longer in ERD
        // =============================================
        Schema::dropIfExists('knmp_konstruksi');
        Schema::dropIfExists('dokumentasi_konstruksi');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate dropped tables
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

        Schema::create('knmp_konstruksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('knmp');
            $table->foreignId('konstruksi_id')->constrained('penyedia_jasa_konstruksi');
            $table->enum('peran', ['utama', 'pendamping']);
            $table->timestamps();
        });

        // Drop tahap_konstruksi
        Schema::dropIfExists('tahap_konstruksi');

        // Restore riwayat_tahap columns
        Schema::table('riwayat_tahap', function (Blueprint $table) {
            $table->uuid('batch_id')->nullable()->index();
            $table->string('created_by')->nullable();
        });

        // Restore progres_harian
        Schema::table('progres_harian', function (Blueprint $table) {
            $table->text('keterangan')->nullable();
        });

        // Restore tahap_serah_terima
        Schema::table('tahap_serah_terima', function (Blueprint $table) {
            $table->decimal('nilai_kontrak', 15, 2)->nullable();
        });

        // Restore tahap_lelang
        Schema::table('tahap_lelang', function (Blueprint $table) {
            $table->string('nomor_paket')->nullable();
            $table->decimal('nilai_hps', 15, 2)->nullable();
            $table->decimal('nilai_kontrak', 15, 2)->nullable();
        });

        // Restore tahap_survey
        Schema::table('tahap_survey', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
        });

        // Restore knmp table
        Schema::table('knmp', function (Blueprint $table) {
            $table->string('tahap')->nullable();
        });
        DB::statement("UPDATE knmp SET tahap = tahap_saat_ini");
        Schema::table('knmp', function (Blueprint $table) {
            $table->dropColumn('tahap_saat_ini');
        });

        Schema::table('knmp', function (Blueprint $table) {
            $table->renameColumn('desa', 'desa_kelurahan');
        });
        Schema::table('knmp', function (Blueprint $table) {
            $table->renameColumn('kabupaten', 'kabupaten_kota');
        });
        Schema::table('knmp', function (Blueprint $table) {
            $table->timestamp('tanggal_mulai')->nullable();
            $table->dropForeign(['batch_id']);
            $table->dropColumn('batch_id');
        });

        // Drop batch table
        Schema::dropIfExists('batch');
    }
};
