<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Imports\ProgresKnmpNasionalImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Knmp;
use App\Models\ProgresKnmpNasional;

echo "--- Debug Import Start ---\n";

// 1. Create a dummy KNMP if likely needed
$knmp = Knmp::first();
if (!$knmp) {
    echo "Creating dummy KNMP...\n";
    $knmp = Knmp::create([
        'nama' => 'Dummy KNMP',
        'provinsi_id' => 1,
        'kabupaten_id' => 1,
        'kecamatan_id' => 1,
        'desa_id' => 1,
    ]);
}
echo "Using KNMP ID: " . $knmp->id . "\n";

// 2. Create a dummy CSV file
$csvContent = "knmp_id,nama_knmp,progres\n";
$csvContent .= "{$knmp->id},Dummy KNMP,50.5\n"; // Valid row
$csvContent .= ",Missing ID,10\n"; // Invalid row
$filePath = __DIR__ . '/test_import.csv';
file_put_contents($filePath, $csvContent);

echo "Created test CSV at $filePath\n";
echo "Content:\n$csvContent\n";

// 3. Run Import
try {
    echo "Running import...\n";
    Excel::import(new ProgresKnmpNasionalImport, $filePath);
    echo "Import command finished.\n";
} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}

// 4. Check Database
$progres = ProgresKnmpNasional::where('knmp_id', $knmp->id)->first();
if ($progres) {
    echo "SUCCESS: Data found in DB! Progres: " . $progres->progres . "\n";
} else {
    echo "FAILURE: Data NOT found in DB.\n";
}

echo "--- Debug Import End ---\n";
