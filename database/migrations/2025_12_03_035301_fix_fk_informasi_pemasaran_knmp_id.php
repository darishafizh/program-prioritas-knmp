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
            $table->dropForeign(['knmp_id']); // hapus FK lama
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_pemasaran', function (Blueprint $table) {
            $table->foreign('knmp_id')
                ->references('id')
                ->on('profile_knmp')
                ->onDelete('cascade');
        });
    }
};
