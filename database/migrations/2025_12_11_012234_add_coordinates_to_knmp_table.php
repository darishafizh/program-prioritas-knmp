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
        Schema::table('knmp', function (Blueprint $table) {
            // Menambahkan kolom latitude dan longitude jika belum ada
            if (!Schema::hasColumn('knmp', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('updated_at');
            }
            if (!Schema::hasColumn('knmp', 'longitude')) {
                $table->decimal('longitude', 11, 7)->nullable()->after('latitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knmp', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
