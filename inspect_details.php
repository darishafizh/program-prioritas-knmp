<?php

use App\Models\ProgresKnmp;
use App\Models\ProgresKnmpDetail;
use App\Models\Knmp;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "--- Inspecting ProgresKnmpDetail ---\n";

// Find a ProgresKnmp that has details
$progres = ProgresKnmp::whereHas('details')->first();

if (!$progres) {
    echo "No ProgresKnmp with details found.\n";
    exit;
}

echo "Progres ID: " . $progres->id . "\n";
echo "KNMP ID: " . $progres->knmp_id . "\n";

$details = $progres->details()->orderBy('kode')->get();

foreach ($details as $d) {
    echo "Kode: [{$d->kode}] - Komponen: [{$d->komponen}] - Persen: [{$d->persen}]\n";
}
