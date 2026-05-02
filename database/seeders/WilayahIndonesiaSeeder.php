<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WilayahIndonesiaSeeder extends Seeder
{
    private const BASE_URL  = 'https://api-regional-indonesia.vercel.app/api';
    private const BATCH     = 500;   // record per upsert
    private const DELAY_MS  = 300;   // jeda antar request (ms)
    private const MAX_RETRY = 3;

    // ----------------------------------------------------------------
    // ENTRY POINT
    // ----------------------------------------------------------------

    public function run(): void
    {
        $this->command->info('');
        $this->command->info('╔══════════════════════════════════════════════════╗');
        $this->command->info('║   Seeder Wilayah Administratif Indonesia         ║');
        $this->command->info('║   Sumber: api-regional-indonesia.vercel.app      ║');
        $this->command->info('╚══════════════════════════════════════════════════╝');
        $this->command->info('');

        DB::disableQueryLog();

        $this->seedProvinsi();
        $this->seedKabupatenKota();
        $this->seedKecamatan();
        $this->seedDesaKelurahan();

        $this->printSummary();
    }

    // ----------------------------------------------------------------
    // LEVEL 1 — PROVINSI
    // ----------------------------------------------------------------

    private function seedProvinsi(): void
    {
        $this->command->info('▶ [1/4] Mengambil data Provinsi...');

        $data = $this->fetchApi('provinces');

        if (empty($data)) {
            $this->command->warn('   Tidak ada data provinsi yang diterima dari API.');
            return;
        }

        $rows = collect($data)->map(fn($p) => [
            'id'         => $p['id'],
            'nama'       => $p['name'],
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        foreach (array_chunk($rows, self::BATCH) as $chunk) {
            DB::table('provinsi')->upsert($chunk, ['id'], ['nama', 'updated_at']);
        }

        $this->command->info("   ✓ " . count($rows) . " provinsi tersimpan.");
        $this->command->info('');
    }

    // ----------------------------------------------------------------
    // LEVEL 2 — KABUPATEN / KOTA
    // ----------------------------------------------------------------

    private function seedKabupatenKota(): void
    {
        $this->command->info('▶ [2/4] Mengambil data Kabupaten/Kota per Provinsi...');

        $provinsiList = DB::table('provinsi')->orderBy('id')->get();
        $total        = 0;
        $bar          = $this->command->getOutput()->createProgressBar($provinsiList->count());
        $bar->start();

        foreach ($provinsiList as $prov) {
            $data = $this->fetchApi("cities/{$prov->id}");

            if (!empty($data)) {
                $rows = collect($data)->map(fn($k) => [
                    'id'          => $k['id'],
                    'provinsi_id' => $k['provinceId'],
                    'nama'        => $k['name'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ])->toArray();

                foreach (array_chunk($rows, self::BATCH) as $chunk) {
                    DB::table('kabupaten_kota')->upsert($chunk, ['id'], ['nama', 'provinsi_id', 'updated_at']);
                }

                $total += count($rows);
            }

            $bar->advance();
            usleep(self::DELAY_MS * 1000);
        }

        $bar->finish();
        $this->command->info('');
        $this->command->info("   ✓ {$total} kabupaten/kota tersimpan.");
        $this->command->info('');
    }

    // ----------------------------------------------------------------
    // LEVEL 3 — KECAMATAN
    // ----------------------------------------------------------------

    private function seedKecamatan(): void
    {
        $this->command->info('▶ [3/4] Mengambil data Kecamatan per Kabupaten/Kota...');

        $kabList = DB::table('kabupaten_kota')->orderBy('id')->get();
        $total   = 0;
        $bar     = $this->command->getOutput()->createProgressBar($kabList->count());
        $bar->start();

        foreach ($kabList as $kab) {
            $data = $this->fetchApi("districts/{$kab->id}");

            if (!empty($data)) {
                $rows = collect($data)->map(fn($k) => [
                    'id'               => $k['id'],
                    'kabupaten_kota_id' => $k['cityId'],
                    'nama'             => $k['name'],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ])->toArray();

                foreach (array_chunk($rows, self::BATCH) as $chunk) {
                    DB::table('kecamatan')->upsert($chunk, ['id'], ['nama', 'kabupaten_kota_id', 'updated_at']);
                }

                $total += count($rows);
            }

            $bar->advance();
            usleep(self::DELAY_MS * 1000);
        }

        $bar->finish();
        $this->command->info('');
        $this->command->info("   ✓ {$total} kecamatan tersimpan.");
        $this->command->info('');
    }

    // ----------------------------------------------------------------
    // LEVEL 4 — DESA / KELURAHAN
    // ----------------------------------------------------------------

    private function seedDesaKelurahan(): void
    {
        $this->command->info('▶ [4/4] Mengambil data Desa/Kelurahan per Kecamatan...');
        $this->command->warn('   ⚠  Proses ini paling lama (~83.436 records). Bisa dijalankan ulang jika terputus.');
        $this->command->info('');

        $kecList = DB::table('kecamatan')->orderBy('id')->get();
        $total   = 0;
        $bar     = $this->command->getOutput()->createProgressBar($kecList->count());
        $bar->start();

        foreach ($kecList as $kec) {
            // Skip jika sudah ada data untuk kecamatan ini (resume mode)
            $exists = DB::table('desa_kelurahan')
                        ->where('kecamatan_id', $kec->id)
                        ->exists();

            if ($exists) {
                $bar->advance();
                continue;
            }

            $data = $this->fetchApi("villages/{$kec->id}");

            if (!empty($data)) {
                $rows = collect($data)->map(fn($d) => [
                    'id'          => $d['id'],
                    'kecamatan_id' => $d['districtId'],
                    'nama'        => $d['name'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ])->toArray();

                foreach (array_chunk($rows, self::BATCH) as $chunk) {
                    DB::table('desa_kelurahan')->upsert($chunk, ['id'], ['nama', 'kecamatan_id', 'updated_at']);
                }

                $total += count($rows);
            }

            $bar->advance();
            usleep(self::DELAY_MS * 1000);
        }

        $bar->finish();
        $this->command->info('');
        $this->command->info("   ✓ {$total} desa/kelurahan tersimpan (sesi ini).");
        $this->command->info('');
    }

    // ----------------------------------------------------------------
    // HELPER — fetch dengan retry
    // ----------------------------------------------------------------

    private function fetchApi(string $endpoint, int $attempt = 1): array
    {
        try {
            $response = Http::timeout(15)
                            ->retry(self::MAX_RETRY, 1000)
                            ->get(self::BASE_URL . '/' . $endpoint);

            if ($response->successful()) {
                $body = $response->json();
                return $body['data'] ?? [];
            }

            return [];
        } catch (\Throwable $e) {
            Log::warning("WilayahSeeder: gagal fetch [{$endpoint}] percobaan {$attempt} — {$e->getMessage()}");

            if ($attempt < self::MAX_RETRY) {
                sleep($attempt);
                return $this->fetchApi($endpoint, $attempt + 1);
            }

            return [];
        }
    }

    // ----------------------------------------------------------------
    // SUMMARY
    // ----------------------------------------------------------------

    private function printSummary(): void
    {
        $nProv = DB::table('provinsi')->count();
        $nKab  = DB::table('kabupaten_kota')->count();
        $nKec  = DB::table('kecamatan')->count();
        $nDes  = DB::table('desa_kelurahan')->count();

        $this->command->info('╔══════════════════════════════════════════════════╗');
        $this->command->info('║   SELESAI — Ringkasan data tersimpan             ║');
        $this->command->info('╠══════════════════════════════════════════════════╣');
        $this->command->info(sprintf('║   Provinsi        : %6s                       ║', number_format($nProv)));
        $this->command->info(sprintf('║   Kabupaten/Kota  : %6s                       ║', number_format($nKab)));
        $this->command->info(sprintf('║   Kecamatan       : %6s                       ║', number_format($nKec)));
        $this->command->info(sprintf('║   Desa/Kelurahan  : %6s                       ║', number_format($nDes)));
        $this->command->info(sprintf('║   TOTAL           : %6s records               ║', number_format($nProv + $nKab + $nKec + $nDes)));
        $this->command->info('╚══════════════════════════════════════════════════╝');
    }
}