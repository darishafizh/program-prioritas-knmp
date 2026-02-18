<?php

use Illuminate\Support\Collection;

require __DIR__.'/vendor/autoload.php';

echo "--- Testing Average Progress Calculation Logic ---\n";

// Mock Data Structure
$mockDetails = new Collection([
    // Component A (Average: (10+30)/2 = 20)
    (object)['kode' => 'A.1', 'persen' => 10],
    (object)['kode' => 'A.2', 'persen' => 30],
    
    // Component B (Average: 50)
    (object)['kode' => 'B.1', 'persen' => 50],
    
    // Component C (Average: 0 - Empty)
    
    // Component D (Average: 100)
    (object)['kode' => 'D.1', 'persen' => 100],
]);

// Logic Replication
$components = ['A', 'B', 'C', 'D'];
$componentAverages = [];

echo "Details:\n";
foreach($mockDetails as $d) echo "  {$d->kode}: {$d->persen}%\n";

foreach ($components as $code) {
    $details = $mockDetails->filter(function ($item) use ($code) {
        return str_starts_with($item->kode, $code);
    });

    if ($details->count() > 0) {
        $avg = $details->avg('persen');
        echo "Component {$code} Avg: {$avg}%\n";
        $componentAverages[] = $avg;
    } else {
        echo "Component {$code} Avg: 0% (No Data)\n";
        $componentAverages[] = 0;
    }
}

$finalAvg = count($componentAverages) > 0 ? array_sum($componentAverages) / count($componentAverages) : 0;

echo "Final Average: {$finalAvg}%\n";

// Expected: (20 + 50 + 0 + 100) / 4 = 170 / 4 = 42.5
if ($finalAvg === 42.5) {
    echo "[PASS] Calculation is correct.\n";
} else {
    echo "[FAIL] Calculation incorrect. Expected 42.5, got {$finalAvg}.\n";
}
