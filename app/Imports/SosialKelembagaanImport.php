<?php

namespace App\Imports;

use App\Models\SosialKelembagaan;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Row;

class SosialKelembagaanImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents
{
    protected $knmpId;

    /**
     * Required columns for this import type
     */
    protected $requiredColumns = [
        'responden_id',
        'anggota_kelompok',
        'anggota_koperasi',
    ];

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
    }

    /**
     * Register events to validate headers before import
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $worksheet = $event->reader->getActiveSheet();
                $headerRow = $worksheet->getRowIterator(1)->current();

                $actualHeaders = [];
                foreach ($headerRow->getCellIterator() as $cell) {
                    $value = $cell->getValue();
                    if (!empty($value)) {
                        $actualHeaders[] = strtolower(trim($value));
                    }
                }

                $missingColumns = array_diff($this->requiredColumns, $actualHeaders);

                if (!empty($missingColumns)) {
                    throw new \Exception(
                        "File Excel tidak sesuai dengan format Sosial Kelembagaan. " .
                        "Kolom yang diperlukan tidak ditemukan: " . implode(', ', $missingColumns) . ". " .
                        "Pastikan Anda menggunakan template yang benar."
                    );
                }
            },
        ];
    }

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        // Use updateOrCreate to prevent duplicates on re-import
        // Helper closure to map scores (same logic as controller)
        $getScore = function($type, $value) {
            if (is_null($value)) return null;
            if (is_numeric($value)) return (int) $value;

            $val = strtolower(trim($value));

            if ($type === 'anggota') {
                if (str_contains($val, 'sangat aktif')) return 4;
                if (str_contains($val, 'tidak aktif')) return 3;
                if (str_contains($val, 'tidak pernah')) return 2;
                if (str_contains($val, 'tidak ada')) return 1;
            }
            if ($type === 'manfaat') {
                if (str_contains($val, 'sangat setuju')) return 5;
                if ($val === 'setuju') return 4;
                if (str_contains($val, 'cukup')) return 3;
                if (str_contains($val, 'kurang')) return 2;
                if (str_contains($val, 'tidak setuju')) return 1;
            }
            if ($type === 'tertarik') {
                 if (str_contains($val, 'sudah menjadi')) return 4;
                 if (str_contains($val, 'sangat tidak')) return 1;
                 if ($val === 'tidak tertarik') return 2;
                 if ($val === 'tertarik') return 3;
            }
            if ($type === 'ya_tidak') {
                if ($val === 'ya') return 1;
                if ($val === 'tidak') return 0;
            }
            return 0;
        };

        // Use updateOrCreate to prevent duplicates on re-import
        SosialKelembagaan::updateOrCreate(
            [
                'knmp_id' => $this->knmpId,
                'responden_id' => $row['responden_id'] ?? null,
            ],
            [
                'anggota_kelompok' => $getScore('anggota', $row['anggota_kelompok'] ?? null),
                'manfaat_kelompok' => $getScore('manfaat', $row['manfaat_kelompok'] ?? null),
                'anggota_koperasi' => $getScore('anggota', $row['anggota_koperasi'] ?? null),
                'tertarik_koperasi' => $getScore('tertarik', $row['tertarik_koperasi'] ?? null),
                'manfaat_koperasi' => $getScore('manfaat', $row['manfaat_koperasi'] ?? null),
                
                'koperasi_rapat_tahunan' => $getScore('ya_tidak', $row['koperasi_rapat_tahunan'] ?? null),
                'koperasi_partisipasi_aktif' => $getScore('ya_tidak', $row['koperasi_partisipasi_aktif'] ?? null),
                'koperasi_pengurus_kompeten' => $getScore('ya_tidak', $row['koperasi_pengurus_kompeten'] ?? null),
                'koperasi_transparan' => $getScore('ya_tidak', $row['koperasi_transparan'] ?? null),
                'koperasi_keuangan_sehat' => $getScore('ya_tidak', $row['koperasi_keuangan_sehat'] ?? null),
                'koperasi_jaringan_pasar' => $getScore('ya_tidak', $row['koperasi_jaringan_pasar'] ?? null),
                'koperasi_kepercayaan_usaha' => $getScore('ya_tidak', $row['koperasi_kepercayaan_usaha'] ?? null),
            ]
        );
    }

    public function rules(): array
    {
        return [
            'responden_id' => 'required|exists:informasi_responden,id',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'responden_id.required' => 'Kolom "responden_id" wajib diisi pada baris :attribute.',
            'responden_id.exists' => 'Responden pada baris :attribute tidak ditemukan di database.',
        ];
    }
}
