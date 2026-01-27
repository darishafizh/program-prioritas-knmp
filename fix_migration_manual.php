<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

echo "--- Starting Manual Migration Fix ---\n";

// 1. Fix 'progres_knmp_nasional' (The one requested)
$tableName = 'progres_knmp_nasional';
$migrationName = '2026_01_26_143700_create_progres_knmp_nasional_table';

if (!Schema::hasTable($tableName)) {
    echo "Creating table '$tableName'...\n";
    try {
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('knmp_id')->unique();
            $table->decimal('progres', 5, 2)->default(0);
            $table->timestamps();

            $table->foreign('knmp_id')
                ->references('id')
                ->on('knmp')
                ->onDelete('cascade');
        });
        echo "SUCCESS: Table '$tableName' created.\n";
    } catch (\Exception $e) {
        echo "ERROR creating table: " . $e->getMessage() . "\n";
        exit(1);
    }
} else {
    echo "NOTICE: Table '$tableName' already exists.\n";
}

// Mark in migrations table
if (!DB::table('migrations')->where('migration', $migrationName)->exists()) {
    DB::table('migrations')->insert([
        'migration' => $migrationName,
        'batch' => DB::table('migrations')->max('batch') + 1
    ]);
    echo "SUCCESS: Marked '$migrationName' as run in DB.\n";
} else {
    echo "NOTICE: '$migrationName' already marked in DB.\n";
}

// 2. Fix 'activity_logs' (Just in case, to unblock future migrations)
$tableActivity = 'activity_logs';
$migrationActivity = '2025_12_30_003437_create_activity_logs_table';

if (Schema::hasTable($tableActivity)) {
    if (!DB::table('migrations')->where('migration', $migrationActivity)->exists()) {
        DB::table('migrations')->insert([
            'migration' => $migrationActivity,
            'batch' => DB::table('migrations')->max('batch') + 1
        ]);
        echo "SUCCESS: Marked existing '$tableActivity' migration as run in DB.\n";
    }
} else {
    echo "NOTICE: '$tableActivity' does not exist yet (skipping manual creation, let duplicate check logic handle it later if needed).\n";
}

echo "--- Fix Completed ---\n";
