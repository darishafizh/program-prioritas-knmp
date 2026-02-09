<?php

namespace App\Imports;

use App\Models\ProgresKnmpNasional;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProgresKnmpNasionalImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithCalculatedFormulas
{
    public $failures = [];
    public $successCount = 0;
    protected $tanggal;

    /**
     * Constructor with date parameter
     */
    public function __construct($tanggal = null)
    {
        $this->tanggal = $tanggal ?? now()->toDateString();
    }

    /**
     * Process the collection of rows from Excel
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        $existingKnmpIds = \App\Models\Knmp::pluck('id')->toArray();

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // Assuming header is row 1

            // 1. Strict Validation: knmp_id must exist
            if (empty($row['knmp_id'])) {
                $this->failures[] = "Baris {$rowNumber}: Kolom 'knmp_id' kosong.";
                continue;
            }

            $knmpId = (int) $row['knmp_id'];

            if (!in_array($knmpId, $existingKnmpIds)) {
                $this->failures[] = "Baris {$rowNumber}: KNMP ID '{$knmpId}' tidak ditemukan di database.";
                continue;
            }

            // 2. Clear numeric parsing
            $progresValue = $row['progres'] ?? 0;
            if (is_string($progresValue)) {
                $progresValue = str_replace(',', '.', $progresValue);
            }
            $progresValue = (float) $progresValue;

            try {
                // Use updateOrCreate to handle both insert and update
                ProgresKnmpNasional::updateOrCreate(
                    [
                        'knmp_id' => $knmpId,
                        'tanggal' => $this->tanggal
                    ],
                    [
                        'progres' => $progresValue
                    ]
                );
                $this->successCount++;
            } catch (\Exception $e) {
                $this->failures[] = "Baris {$rowNumber}: Gagal menyimpan database. " . $e->getMessage();
            }
        }
    }
}
