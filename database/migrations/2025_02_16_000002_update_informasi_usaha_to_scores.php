<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if already converted to integer to avoid errors
        if (Schema::hasColumn('informasi_usaha', 'jenis_bahan_baku') && Schema::getColumnType('informasi_usaha', 'jenis_bahan_baku') === 'int') {
            return;
        }
        // 1. Convert existing text data to scores using raw SQL

        // Jenis Bahan Baku
        // Fiber (4), Kayu Laminasi (3), Kayu (2), Besi (1), Lainnya (1)
        DB::statement("UPDATE informasi_usaha SET jenis_bahan_baku = '4' WHERE jenis_bahan_baku = 'Fiber'");
        DB::statement("UPDATE informasi_usaha SET jenis_bahan_baku = '3' WHERE jenis_bahan_baku = 'Kayu Laminasi'");
        DB::statement("UPDATE informasi_usaha SET jenis_bahan_baku = '2' WHERE jenis_bahan_baku = 'Kayu'");
        DB::statement("UPDATE informasi_usaha SET jenis_bahan_baku = '1' WHERE jenis_bahan_baku IN ('Besi', 'Lainnya')");
        // Set everything else to NULL if it doesn't match known values (or handle as 1/other if needed, but safest is null or 1)
        DB::statement("UPDATE informasi_usaha SET jenis_bahan_baku = NULL WHERE jenis_bahan_baku NOT IN ('1','2','3','4')");


        // Jenis Mesin
        // Motor Tempel Pribadi (4), Motor Tempel Bantuan (3), Sampan (1)
        DB::statement("UPDATE informasi_usaha SET jenis_mesin = '4' WHERE jenis_mesin = 'Motor Tempel Pribadi'");
        DB::statement("UPDATE informasi_usaha SET jenis_mesin = '3' WHERE jenis_mesin = 'Motor Tempel Bantuan'");
        DB::statement("UPDATE informasi_usaha SET jenis_mesin = '1' WHERE jenis_mesin LIKE '%Sampan%'"); // Sampan (tanpa motor)
        DB::statement("UPDATE informasi_usaha SET jenis_mesin = NULL WHERE jenis_mesin NOT IN ('1','3','4')");


        // Alat Penyimpanan
        // Coolbox (4), Palka (3), Stereofoam Box (2), Tong plastik (1), Lainnya (1)
        DB::statement("UPDATE informasi_usaha SET alat_penyimpanan = '4' WHERE alat_penyimpanan = 'Coolbox'");
        DB::statement("UPDATE informasi_usaha SET alat_penyimpanan = '3' WHERE alat_penyimpanan = 'Palka'");
        DB::statement("UPDATE informasi_usaha SET alat_penyimpanan = '2' WHERE alat_penyimpanan = 'Stereofoam Box'");
        DB::statement("UPDATE informasi_usaha SET alat_penyimpanan = '1' WHERE alat_penyimpanan IN ('Tong plastik', 'Lainnya')");
        DB::statement("UPDATE informasi_usaha SET alat_penyimpanan = NULL WHERE alat_penyimpanan NOT IN ('1','2','3','4')");


        // 2. Change column types to integer
        Schema::table('informasi_usaha', function (Blueprint $table) {
            $table->integer('jenis_bahan_baku')->nullable()->change();
            $table->integer('jenis_mesin')->nullable()->change();
            $table->integer('alat_penyimpanan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_usaha', function (Blueprint $table) {
            $table->string('jenis_bahan_baku')->nullable()->change();
            $table->string('jenis_mesin')->nullable()->change();
            $table->string('alat_penyimpanan')->nullable()->change();
        });
    }
};
