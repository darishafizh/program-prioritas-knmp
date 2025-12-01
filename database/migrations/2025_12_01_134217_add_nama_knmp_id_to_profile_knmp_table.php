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
        Schema::table('profile_knmp', function (Blueprint $table) {
            $table->unsignedBigInteger('knmp_id')->after('id')->nullable();
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
        Schema::table('profile_knmp', function (Blueprint $table) {
            $table->dropForeign(['knmp_id']);
            $table->dropColumn('knmp_id');
        });
    }
};
