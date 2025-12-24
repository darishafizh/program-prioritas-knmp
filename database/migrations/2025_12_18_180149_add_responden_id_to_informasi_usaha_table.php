<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('informasi_usaha', function (Blueprint $table) {
            if (!Schema::hasColumn('informasi_usaha', 'responden_id')) {
                $table->unsignedBigInteger('responden_id')
                    ->nullable()
                    ->after('knmp_id');
            }

            // ❌ TIDAK pakai FK dulu (aman)
            // Kalau nanti mau, bisa ditambah belakangan
        });
    }

    public function down(): void
    {
        Schema::table('informasi_usaha', function (Blueprint $table) {
            if (Schema::hasColumn('informasi_usaha', 'responden_id')) {
                $table->dropColumn('responden_id');
            }
        });
    }
};
