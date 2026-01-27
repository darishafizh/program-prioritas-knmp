<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Imports\ProgresKnmpNasionalImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Knmp;
use Illuminate\Support\Facades\DB;

echo "--- Debug Strict Import Start ---\n";

// 1. Setup Test Data
$knmp = Knmp::first();
if (!$knmp) {
    $knmp = Knmp::create([
        'nama' => 'Dummy KNMP',
        'provinsi_id' => 1,
        'kabupaten_id' => 1,
        'kecamatan_id' => 1,
        'desa_id' => 1,
    ]);
}
$validId = $knmp->id;
$invalidId = 999999; // Assume this doesn't exist

// 2. Create Mixed CSV
$csvContent = "knmp_id,progres\n";
$csvContent .= "{$validId},75.5\n";     // Valid
$csvContent .= "{$invalidId},10\n";      // Invalid ID
$csvContent .= ",50\n";                  // Empty ID

$filePath = __DIR__ . '/test_strict_import.csv';
file_put_contents($filePath, $csvContent);

echo "Testing with CSV:\n$csvContent\n";

// 3. Run Import
try {
    $import = new ProgresKnmpNasionalImport;
    Excel::import($import, $filePath);

    echo "\n--- Result ---\n";
    echo "Success Count: " . $import->successCount . "\n";
    echo "Failures Count: " . count($import->failures) . "\n";

    if (count($import->failures) > 0) {
        echo "Failure Messages:\n";
        foreach ($import->failures as $fail) {
            echo "- $fail\n";
        }
    }

} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}

echo "--- Debug End ---\n";
