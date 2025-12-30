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
        Schema::table('informasi_pemasaran', function (Blueprint $table) {
            Schema::table('informasi_pemasaran', function (Blueprint $table) {
            $table->foreign('knmp_id')
                ->references('id')
                ->on('knmp')        // sekarang benar!
                ->onDelete('cascade');
        });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_pemasaran', function (Blueprint $table) {
            $table->dropForeign(['knmp_id']);
        });
    }
};
