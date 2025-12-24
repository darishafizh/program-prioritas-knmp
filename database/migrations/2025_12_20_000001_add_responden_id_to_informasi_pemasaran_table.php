<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('informasi_pemasaran', function (Blueprint $table) {

            // Tambah kolom
            $table->unsignedBigInteger('responden_id')
                ->nullable()
                ->after('knmp_id');

            // Foreign key
            $table->foreign('responden_id')
                ->references('id')
                ->on('informasi_responden')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('informasi_pemasaran', function (Blueprint $table) {
            $table->dropForeign(['responden_id']);
            $table->dropColumn('responden_id');
        });
    }
};
