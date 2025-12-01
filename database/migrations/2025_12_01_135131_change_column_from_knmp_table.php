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
            $table->string('desa', 100)->after('nama')->nullable();
            $table->string('kecamatan', 100)->after('desa')->nullable();
            $table->string('kabupaten', 100)->after('kecamatan')->nullable();
            $table->string('provinsi', 100)->after('kabupaten')->nullable();
            $table->dropColumn('desa_id');
            $table->dropColumn('kecamatan_id');
            $table->dropColumn('kabupaten_id');
            $table->dropColumn('provinsi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knmp', function (Blueprint $table) {
            $table->unsignedBigInteger('provinsi_id')->nullable()->after('nama');
            $table->unsignedBigInteger('kabupaten_id')->nullable()->after('provinsi_id');
            $table->unsignedBigInteger('kecamatan_id')->nullable()->after('kabupaten_id');
            $table->unsignedBigInteger('desa_id')->nullable()->after('kecamatan_id');
            $table->dropColumn('provinsi');
            $table->dropColumn('kabupaten');
            $table->dropColumn('kecamatan');
            $table->dropColumn('desa');
        });
    }
};
