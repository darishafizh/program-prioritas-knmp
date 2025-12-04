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
        Schema::table('tingkat_kebahagiaan_nelayan', function (Blueprint $table) {
            $table->dropForeign(['knmp_id']);
            $table->foreign('knmp_id')
                ->references('id')
                ->on('knmp')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tingkat_kebahagiaan_nelayan', function (Blueprint $table) {
            $table->dropForeign(['knmp_id']);
            // kembalikan ke FK semula ke profile_knmp (jika perlu)
            $table->foreign('knmp_id')
                ->references('id')
                ->on('profile_knmp')
                ->onDelete('cascade');
        });
    }
};
