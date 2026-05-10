<?php

namespace App\Services;

use App\Models\Knmp;
use App\Models\RiwayatTahap;
use Illuminate\Support\Facades\DB;

class KnmpStageService
{
    /**
     * Daftar tahap dalam urutan alur program.
     */
    public const STAGES = ['usulan', 'survey', 'ded', 'lelang', 'konstruksi', 'serah_terima'];

    /**
     * Pindahkan satu KNMP ke tahap baru.
     */
    public function moveToStage(Knmp $knmp, string $newStage, ?string $keterangan = null): Knmp
    {
        return DB::transaction(function () use ($knmp, $newStage, $keterangan) {
            $oldStage = $knmp->tahap_saat_ini;

            if ($oldStage === $newStage) {
                return $knmp;
            }

            // 1. Update tahap saat ini
            $knmp->tahap_saat_ini = $newStage;
            $knmp->save();

            // 2. Catat riwayat tahap
            RiwayatTahap::create([
                'knmp_id'    => $knmp->id,
                'tahap_dari' => $oldStage,
                'tahap_ke'   => $newStage,
                'keterangan' => $keterangan,
            ]);

            return $knmp;
        });
    }

    /**
     * Pindahkan beberapa KNMP sekaligus (Batch).
     */
    public function batchMoveToStage(array $knmpIds, string $newStage, ?string $keterangan = null): void
    {
        DB::transaction(function () use ($knmpIds, $newStage, $keterangan) {
            $knmps = Knmp::whereIn('id', $knmpIds)->lockForUpdate()->get();

            foreach ($knmps as $knmp) {
                $this->moveToStage($knmp, $newStage, $keterangan);
            }
        });
    }

    /**
     * Cek apakah tahap tujuan valid.
     */
    public static function isValidStage(string $stage): bool
    {
        return in_array($stage, self::STAGES, true);
    }
}
