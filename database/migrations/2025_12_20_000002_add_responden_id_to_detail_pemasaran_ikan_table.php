<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_pemasaran_ikan', function (Blueprint $table) {
            if (!Schema::hasColumn('detail_pemasaran_ikan', 'responden_id')) {
                // Tambah kolom
                $table->unsignedBigInteger('responden_id')
                    ->nullable()
                    ->after('pemasaran_id');

                // Foreign key
                $table->foreign('responden_id')
                    ->references('id')
                    ->on('informasi_responden')
                    ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('detail_pemasaran_ikan', function (Blueprint $table) {
            $table->dropForeign(['responden_id']);
            $table->dropColumn('responden_id');
        });
    }
};
