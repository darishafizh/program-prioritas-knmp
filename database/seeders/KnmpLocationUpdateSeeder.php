<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnmpLocationUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('knmp.csv');
        
        if (!file_exists($csvFile)) {
            $this->command->error("File knmp.csv tidak ditemukan di root project.");
            return;
        }

        $handle = fopen($csvFile, 'r');
        
        // Skip header
        $header = fgetcsv($handle, 0, ';');
        
        $count = 0;
        while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
            // Mapping berdasarkan index di CSV:
            // 0: id
            // 5: kabupaten
            // 6: kecamatan
            // 7: desa
            
            $id = $data[0];
            $kabupaten = $data[5] ?? null;
            $kecamatan = $data[6] ?? null;
            $desa = $data[7] ?? null;
            $penyedia = $data[10] ?? null;

            if ($id) {
                // Update lokasi di tabel knmp
                DB::table('knmp')->where('id', $id)->update([
                    'kabupaten_kota' => $kabupaten,
                    'kecamatan' => $kecamatan,
                    'desa_kelurahan' => $desa,
                ]);

                // Update nama penyedia di tabel progres_harian (jika ada)
                if ($penyedia) {
                    DB::table('progres_harian')
                        ->where('knmp_id', $id)
                        ->update(['nama_jasa_konstruksi' => $penyedia]);
                }
                
                $count++;
            }
        }

        fclose($handle);
        $this->command->info("Berhasil mengupdate {$count} data KNMP dari CSV.");
    }
}
