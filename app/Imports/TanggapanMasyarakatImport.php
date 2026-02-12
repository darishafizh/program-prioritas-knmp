<?php

namespace App\Imports;

use App\Models\TanggapanMasyarakat;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Row;

class TanggapanMasyarakatImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents
{
    protected $knmpId;

    /**
     * Required columns for this import type
     */
    protected $requiredColumns = [
        'responden_id',
        'kesesuaian_kebutuhan',
        'tingkat_kesenangan',
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
                        "File Excel tidak sesuai dengan format Tanggapan Masyarakat. " .
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
        TanggapanMasyarakat::updateOrCreate(
            [
                'knmp_id' => $this->knmpId,
                'responden_id' => $row['responden_id'] ?? null,
            ],
            [
                'kesesuaian_kebutuhan' => $this->parseKesesuaian($row['kesesuaian_kebutuhan'] ?? null),
                'item_tidak_sesuai' => $row['item_tidak_sesuai'] ?? null,
                'tingkat_kesenangan' => $this->parseKesenangan($row['tingkat_kesenangan'] ?? null),
                'alasan_tidak_senang' => $row['alasan_tidak_senang'] ?? null,
                'harapan_masyarakat' => $row['harapan_masyarakat'] ?? null,
                'masukan_saran_perbaikan' => $row['masukan_saran_perbaikan'] ?? null,
            ]
        );
    }

    /**
     * Convert kesesuaian_kebutuhan text to numeric value.
     * "Ya, sesuai" => 1, "Tidak sesuai" => 0
     */
    protected function parseKesesuaian($value)
    {
        if (is_null($value))
            return null;

        if (is_numeric($value))
            return (int) $value;

        $normalized = strtolower(trim($value));

        $map = [
            'ya, sesuai' => 1,
            'ya sesuai' => 1,
            'sesuai' => 1,
            'ya' => 1,
            'yes' => 1,
            'tidak sesuai' => 0,
            'tidak' => 0,
            'no' => 0,
        ];

        return $map[$normalized] ?? null;
    }

    /**
     * Convert tingkat_kesenangan text — normalizes common variations.
     */
    protected function parseKesenangan($value)
    {
        if (is_null($value) || trim($value) === '')
            return null;

        $normalized = strtolower(trim($value));

        $map = [
            'senang' => 'Senang',
            'biasa saja' => 'Biasa saja',
            'biasa' => 'Biasa saja',
            'tidak senang' => 'Tidak Senang',
            'tidak' => 'Tidak Senang',
        ];

        return $map[$normalized] ?? $value;
    }

    public function rules(): array
    {
        return [
            'responden_id' => 'required|exists:informasi_responden,id',
            'kesesuaian_kebutuhan' => 'required',
            'tingkat_kesenangan' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'responden_id.required' => 'Kolom "responden_id" wajib diisi pada baris :attribute.',
            'responden_id.exists' => 'Responden pada baris :attribute tidak ditemukan di database.',
            'kesesuaian_kebutuhan.required' => 'Kolom "kesesuaian_kebutuhan" wajib diisi pada baris :attribute. Pilih: Ya, sesuai atau Tidak sesuai.',
            'tingkat_kesenangan.required' => 'Kolom "tingkat_kesenangan" wajib diisi pada baris :attribute. Pilih: Senang, Biasa saja, atau Tidak Senang.',
        ];
    }
}
