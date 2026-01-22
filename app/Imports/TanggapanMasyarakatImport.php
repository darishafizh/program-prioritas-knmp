<?php

namespace App\Imports;

use App\Models\TanggapanMasyarakat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;

class TanggapanMasyarakatImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents
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

    public function model(array $row)
    {
        return new TanggapanMasyarakat([
            'knmp_id' => $this->knmpId,
            'responden_id' => $row['responden_id'] ?? null,
            'kesesuaian_kebutuhan' => $this->parseBoolean($row['kesesuaian_kebutuhan'] ?? null),
            'item_tidak_sesuai' => $row['item_tidak_sesuai'] ?? null,
            'tingkat_kesenangan' => $row['tingkat_kesenangan'] ?? null,
            'alasan_tidak_senang' => $row['alasan_tidak_senang'] ?? null,
            'harapan_masyarakat' => $row['harapan_masyarakat'] ?? null,
            'masukan_saran_perbaikan' => $row['masukan_saran_perbaikan'] ?? null,
        ]);
    }

    protected function parseBoolean($value)
    {
        if (is_null($value))
            return null;
        if (is_bool($value))
            return $value;
        $value = strtolower(trim($value));
        return in_array($value, ['ya', 'yes', '1', 'true', 'sesuai']);
    }

    public function rules(): array
    {
        return [
            'responden_id' => 'required|exists:informasi_responden,id',
        ];
    }
}
