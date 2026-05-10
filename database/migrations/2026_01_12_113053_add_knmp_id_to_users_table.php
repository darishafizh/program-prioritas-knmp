<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'knmp_id')) {
                $table->unsignedBigInteger('knmp_id')->nullable()->after('id');
                $table->foreign('knmp_id')->references('id')->on('knmp')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['knmp_id']);
            $table->dropColumn('knmp_id');
        });
    }
};
