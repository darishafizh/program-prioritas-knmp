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
        // 1. Add the new column
        Schema::table('progres_harian', function (Blueprint $table) {
            $table->unsignedBigInteger('knmp_konstruksi_id')->nullable()->after('knmp_id');
        });

        // 2. Migrate existing data
        // We join progres_harian with konstruksi_knmp on knmp_id
        DB::table('progres_harian')
            ->join('konstruksi_knmp', 'progres_harian.knmp_id', '=', 'konstruksi_knmp.knmp_id')
            ->update([
                'progres_harian.knmp_konstruksi_id' => DB::raw('konstruksi_knmp.id')
            ]);

        // 3. Drop the old column
        Schema::table('progres_harian', function (Blueprint $table) {
            $table->dropColumn('knmp_id');
            $table->foreign('knmp_konstruksi_id')->references('id')->on('konstruksi_knmp')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progres_harian', function (Blueprint $table) {
            $table->unsignedBigInteger('knmp_id')->nullable()->after('id');
        });

        // Reverse data migration
        DB::table('progres_harian')
            ->join('konstruksi_knmp', 'progres_harian.knmp_konstruksi_id', '=', 'konstruksi_knmp.id')
            ->update([
                'progres_harian.knmp_id' => DB::raw('konstruksi_knmp.knmp_id')
            ]);

        Schema::table('progres_harian', function (Blueprint $table) {
            $table->dropForeign(['knmp_konstruksi_id']);
            $table->dropColumn('knmp_konstruksi_id');
        });
    }

};
