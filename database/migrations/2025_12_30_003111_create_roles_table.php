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
        // Table for roles
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique(); // admin, enumerator
                $table->string('display_name'); // Admin, Enumerator
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        // Pivot table for user-role relationship
        if (!Schema::hasTable('role_user')) {
            Schema::create('role_user', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('role_id')->constrained()->onDelete('cascade');
                $table->primary(['user_id', 'role_id']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
};
