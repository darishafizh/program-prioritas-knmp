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
        $tables = [
            'riwayat_tahap',
            'tahap_usulan',
            'tahap_survey',
            'tahap_ded',
            'tahap_lelang',
            'tahap_serah_terima',
            'progres_harian',
            'dokumentasi_konstruksi',
            'knmp_konstruksi',
            'bukti_uploads',
            'profile_knmp',
            'progres_knmp',
            'informasi_responden',
            'progres_knmp_nasional'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                // Get existing foreign keys for knmp_id in this table
                $existingFks = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = ? 
                    AND COLUMN_NAME = 'knmp_id' 
                    AND REFERENCED_TABLE_NAME = 'knmp'
                ", [$tableName]);

                Schema::table($tableName, function (Blueprint $table) use ($existingFks) {
                    foreach ($existingFks as $fk) {
                        $table->dropForeign($fk->CONSTRAINT_NAME);
                    }
                    
                    $table->foreign('knmp_id')
                        ->references('id')
                        ->on('knmp')
                        ->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knmp_relations', function (Blueprint $table) {
            //
        });
    }
};
