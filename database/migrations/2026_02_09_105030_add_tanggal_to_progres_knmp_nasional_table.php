<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add tanggal column if not exists
        Schema::table('progres_knmp_nasional', function (Blueprint $table) {
            if (!Schema::hasColumn('progres_knmp_nasional', 'tanggal')) {
                $table->date('tanggal')->nullable()->after('progres');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progres_knmp_nasional', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });
    }
};
