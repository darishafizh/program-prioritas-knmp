<?php

namespace App\Imports;

use App\Models\Knmp;
use App\Models\TahapUsulan;
use App\Models\RiwayatTahap;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class UsulanImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip if required name is missing
        if (empty($row['nama'])) {
            return null;
        }

        return DB::transaction(function () use ($row) {
            // 1. Create or Find KNMP
            $knmp = Knmp::updateOrCreate(
                ['nama' => $row['nama']],
                [
                    'provinsi'       => $row['provinsi'] ?? null,
                    'kabupaten_kota' => $row['kabupaten_kota'] ?? null,
                    'kecamatan'      => $row['kecamatan'] ?? null,
                    'desa_kelurahan' => $row['desa_kelurahan'] ?? null,
                    'tahap'          => 'usulan',
                ]
            );

            // 2. Create or Update Tahap Usulan data
            TahapUsulan::updateOrCreate(
                ['knmp_id' => $knmp->id],
                [
                    'tanggal' => $this->transformDate($row['tanggal'] ?? null),
                    'catatan' => $row['catatan'] ?? null,
                ]
            );

            // 3. Optional: Add initial history if it's new
            if ($knmp->wasRecentlyCreated) {
                RiwayatTahap::create([
                    'knmp_id'    => $knmp->id,
                    'tahap_dari' => null,
                    'tahap_ke'   => 'usulan',
                    'keterangan' => 'Import awal dari Excel',
                    'created_by' => auth()->check() ? (string) auth()->id() : 'system',
                ]);
            }

            return $knmp;
        });
    }

    /**
     * Transform Excel date to Y-m-d
     */
    private function transformDate($value)
    {
        if (empty($value)) return null;

        try {
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            return date('Y-m-d', strtotime($value));
        } catch (\Exception $e) {
            return null;
        }
    }
}
