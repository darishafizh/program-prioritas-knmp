<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tanggapan_masyarakat', function (Blueprint $table) {
            if (!Schema::hasColumn('tanggapan_masyarakat', 'responden_id')) {
                $table->foreignId('responden_id')
                    ->after('knmp_id')
                    ->constrained('informasi_responden')
                    ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tanggapan_masyarakat', function (Blueprint $table) {

            $table->dropForeign(['responden_id']);
            $table->dropColumn('responden_id');
        });
    }
};
