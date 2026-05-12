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
            if (Schema::hasColumn('knmp', 'kabupaten_kota')) {
                $table->renameColumn('kabupaten_kota', 'kabupaten');
            }
            if (Schema::hasColumn('knmp', 'desa_kelurahan')) {
                $table->renameColumn('desa_kelurahan', 'desa');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knmp', function (Blueprint $table) {
            if (Schema::hasColumn('knmp', 'kabupaten')) {
                $table->renameColumn('kabupaten', 'kabupaten_kota');
            }
            if (Schema::hasColumn('knmp', 'desa')) {
                $table->renameColumn('desa', 'desa_kelurahan');
            }
        });
    }
};
