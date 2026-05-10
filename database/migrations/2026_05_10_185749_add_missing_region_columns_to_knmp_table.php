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
            $table->string('kabupaten_kota')->nullable()->after('provinsi');
            $table->string('kecamatan')->nullable()->after('kabupaten_kota');
            $table->string('desa_kelurahan')->nullable()->after('kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knmp', function (Blueprint $table) {
            $table->dropColumn(['kabupaten_kota', 'kecamatan', 'desa_kelurahan']);
        });
    }
};
