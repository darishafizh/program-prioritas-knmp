<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$csvFile = base_path('knmp.csv');
$handle = fopen($csvFile, 'r');
$header = fgetcsv($handle, 0, ';');

$count = 0;
while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
    $id = $data[0];
    $penyedia_nama = trim($data[10] ?? '');

    if ($id && $penyedia_nama && $penyedia_nama !== '-') {
        // Verify knmp exists
        $knmp = DB::table('knmp')->where('id', $id)->first();
        if (!$knmp) continue;

        // Find penyedia ID
        $penyedia = DB::table('penyedia_jasa_konstruksi')->where('nama', $penyedia_nama)->first();
        if ($penyedia) {
            // Check if tahap_konstruksi exists for this knmp_id
            $exists = DB::table('tahap_konstruksi')->where('knmp_id', $id)->exists();
            if (!$exists) {
                DB::table('tahap_konstruksi')->insert([
                    'knmp_id' => $id,
                    'jasa_konstruksi_id' => $penyedia->id,
                    'periode_mingguan' => null,
                    'bobot_rencana_kumulatif' => null,
                    'bobot_realisasi_kumulatif' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $count++;
            } else {
                DB::table('tahap_konstruksi')->where('knmp_id', $id)->whereNull('jasa_konstruksi_id')->update([
                    'jasa_konstruksi_id' => $penyedia->id
                ]);
            }
        }
    }
}
fclose($handle);
echo "Imported $count missing penyedia\n";
