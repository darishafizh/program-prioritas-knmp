<?php

namespace App\Imports;

use App\Models\SosialKelembagaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;

class SosialKelembagaanImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents
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

    public function model(array $row)
    {
        return new SosialKelembagaan([
            'knmp_id' => $this->knmpId,
            'responden_id' => $row['responden_id'] ?? null,
            'anggota_kelompok' => $row['anggota_kelompok'] ?? null,
            'manfaat_kelompok' => $row['manfaat_kelompok'] ?? null,
            'anggota_koperasi' => $row['anggota_koperasi'] ?? null,
            'tertarik_koperasi' => $row['tertarik_koperasi'] ?? null,
            'manfaat_koperasi' => $row['manfaat_koperasi'] ?? null,
            'koperasi_rapat_tahunan' => $row['koperasi_rapat_tahunan'] ?? null,
            'koperasi_partisipasi_aktif' => $row['koperasi_partisipasi_aktif'] ?? null,
            'koperasi_pengurus_kompeten' => $row['koperasi_pengurus_kompeten'] ?? null,
            'koperasi_transparan' => $row['koperasi_transparan'] ?? null,
            'koperasi_keuangan_sehat' => $row['koperasi_keuangan_sehat'] ?? null,
            'koperasi_jaringan_pasar' => $row['koperasi_jaringan_pasar'] ?? null,
            'koperasi_kepercayaan_usaha' => $row['koperasi_kepercayaan_usaha'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'responden_id' => 'required|exists:informasi_responden,id',
        ];
    }
}
