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
        Schema::table('knmp', function (Blueprint $table) {
            $table->renameColumn('province_id', 'provinsi');
            $table->renameColumn('regency_id', 'kabupaten_kota');
            $table->renameColumn('district_id', 'kecamatan');
            $table->renameColumn('village_id', 'desa_kelurahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knmp', function (Blueprint $table) {
            $table->renameColumn('provinsi', 'province_id');
            $table->renameColumn('kabupaten_kota', 'regency_id');
            $table->renameColumn('kecamatan', 'district_id');
            $table->renameColumn('desa_kelurahan', 'village_id');
        });
    }
};
