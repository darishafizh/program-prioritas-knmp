<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "--- Testing Layout Refactor ---\n";

// Login a user
$user = \App\Models\User::first();
if (!$user) {
    echo "No User found. Skipping test.\n";
    exit(0);
}
auth()->login($user);

// Mock Data
$selectedKnmp = (object)[
    'id' => 1, 'nama' => 'Test KNMP', 
    'province' => (object)['name'=>'Prov'], 
    'regency' => (object)['name'=>'Kab'], 
    'district' => (object)['name'=>'Kec'], 
    'village' => (object)['name'=>'Desa'],
    'latitude' => -5, 'longitude' => 105
];
$stats = [
    'jmlKepalaKeluarga' => 0, 'totalNelayan' => 0, 'jumlahKapal' => 0, 'serapanTenagaKerja' => 0,
    'pendapatanNelayan' => 2500000,
    'koperasiDesaMerahPutih' => [
        'nama' => 'Koperasi Maju', 'ketua' => 'Budi', 'sk' => 'SK-123', 'anggotaLaki' => 10, 'anggotaPerempuan' => 5
    ],
    'volumeKomoditas1' => 100, 'nilaiKomoditas1' => 5000000, 
    'komoditas1' => 'Ikan', 'hargaKomoditas1' => 50000,
    'komoditas2' => '-', 'hargaKomoditas2' => 0,
    'progres' => (object)['anggaran_konstruksi' => 0, 'anggaran_sarpras' => 0]
];
$monitoringStats = ['responden' => ['total' => 0], 'bukti' => ['totalFiles'=>0, 'totalSize'=>0, 'files'=>[]]];

try {
    $view = view('informasi_umum.index', [
        'knmpList' => [],
        'selectedKnmp' => $selectedKnmp,
        'selectedKnmpId' => 1,
        'monitoringStats' => $monitoringStats,
        'stats' => $stats
    ])->render();
    
    // Checks
    $posPendapatan = strpos($view, 'Avg. Pendapatan Nelayan');
    $posKoperasi = strpos($view, 'Koperasi Desa Merah Putih');
    $posMap = strpos($view, 'id="knmpMap"');
    $posProduksi = strpos($view, 'Data Produksi & Komoditas');
    
    if ($posPendapatan !== false) echo "[PASS] 'Avg. Pendapatan' found.\n";
    else echo "[FAIL] 'Avg. Pendapatan' NOT found.\n";
    
    if ($posKoperasi !== false) echo "[PASS] 'Koperasi' found.\n";
    else echo "[FAIL] 'Koperasi' NOT found.\n";
    
    if ($posMap !== false) echo "[PASS] Map container found.\n";
    else echo "[FAIL] Map container NOT found.\n";
    
    if ($posProduksi !== false) echo "[PASS] 'Data Produksi' found.\n";
    else echo "[FAIL] 'Data Produksi' NOT found.\n";
    
    // Verify Order: Pendapatan < Produksi
    if ($posPendapatan < $posProduksi) echo "[PASS] Pendapatan appears BEFORE Data Produksi.\n";
    else echo "[FAIL] Pendapatan appears AFTER Data Produksi (Order Incorrect).\n";
    
    // Verify Order: Map < Produksi
    if ($posMap < $posProduksi) echo "[PASS] Map appears BEFORE Data Produksi.\n";
    else echo "[FAIL] Map appears AFTER Data Produksi (Order Incorrect).\n";

} catch (\Exception $e) {
    echo "[ERROR] Rendering Failed: " . $e->getMessage() . "\n";
}
