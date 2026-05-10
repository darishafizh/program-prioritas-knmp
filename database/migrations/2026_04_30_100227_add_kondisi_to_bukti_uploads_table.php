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
        Schema::table('bukti_uploads', function (Blueprint $table) {
            if (!Schema::hasColumn('bukti_uploads', 'kondisi')) {
                $table->enum('kondisi', ['before', 'after'])->nullable()->after('knmp_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukti_uploads', function (Blueprint $table) {
            $table->dropColumn('kondisi');
        });
    }
};
