<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds the 'super_admin' role to the roles table.
     */
    public function up(): void
    {
        DB::table('roles')->insertOrIgnore([
            'name' => 'super_admin',
            'display_name' => 'Super Admin',
            'description' => 'Super Administrator dengan kontrol penuh ke semua fitur dan dapat menginput semua KNMP',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('roles')->where('name', 'super_admin')->delete();
    }
};
