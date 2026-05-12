<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check tahap_konstruksi for a specific knmp - see the tanggal_mulai
$res = DB::table('tahap_konstruksi')
    ->where('knmp_id', 109)
    ->select('id', 'knmp_id', 'jasa_konstruksi_id', 'tanggal_mulai', 'periode_mingguan', 'bobot_rencana_kumulatif', 'bobot_realisasi_kumulatif')
    ->orderBy('periode_mingguan')
    ->take(5)
    ->get();
echo "tahap_konstruksi for knmp 109:\n";
echo json_encode($res, JSON_PRETTY_PRINT);

// Check progres_harian for the same knmp
$ph = DB::table('progres_harian')
    ->where('knmp_id', 109)
    ->select('id', 'knmp_id', 'progres', 'tanggal')
    ->orderBy('tanggal')
    ->get();
echo "\n\nprogres_harian for knmp 109:\n";
echo json_encode($ph, JSON_PRETTY_PRINT);

// Check tahap 1 knmp tanggal_mulai
$t1 = DB::table('tahap_konstruksi')
    ->whereIn('knmp_id', function($q) {
        $q->select('id')->from('knmp')->where('batch_id', 1);
    })
    ->select('id', 'knmp_id', 'tanggal_mulai', 'periode_mingguan')
    ->take(5)
    ->get();
echo "\n\ntahap_konstruksi for batch 1 knmps:\n";
echo json_encode($t1, JSON_PRETTY_PRINT);
