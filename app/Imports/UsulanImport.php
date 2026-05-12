<?php

namespace App\Imports;

use App\Models\Knmp;
use App\Models\TahapUsulan;
use App\Models\RiwayatTahap;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class UsulanImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Support both variations of header names
        $namaRaw   = trim($row['nama'] ?? $row['nama_knmp'] ?? '');
        $desaRaw   = trim($row['desa_kelurahan'] ?? $row['desa'] ?? '');

        // Skip only if BOTH name and village are empty
        if ($namaRaw === '' && $desaRaw === '') {
            return null;
        }

        // If name is missing but village exists, use village as name
        if ($namaRaw === '') {
            $namaRaw = "KNMP Desa " . $desaRaw;
        }

        return DB::transaction(function () use ($row, $namaRaw, $desaRaw) {
            $provinsi  = trim($row['provinsi'] ?? $row['province'] ?? '');
            $kabupaten = trim($row['kabupaten_kota'] ?? $row['kabupaten'] ?? $row['regency'] ?? '');
            $kecamatan = trim($row['kecamatan'] ?? $row['district'] ?? '');
            $status    = trim($row['status'] ?? '');

            // 1. Create KNMP (Always create new to avoid merging duplicates)
            $knmp = Knmp::create([
                'nama'           => $namaRaw,
                'provinsi'       => $provinsi,
                'kabupaten'      => $kabupaten,
                'kecamatan'      => $kecamatan,
                'desa'           => $desaRaw,
                'status'         => $status,
                'tahap_saat_ini' => 'usulan',
            ]);

            // 2. Create Tahap Usulan data
            TahapUsulan::create([
                'knmp_id' => $knmp->id,
                'tanggal' => $this->transformDate($row['tanggal'] ?? null),
                'catatan' => $row['catatan'] ?? null,
            ]);

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
