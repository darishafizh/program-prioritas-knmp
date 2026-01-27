<?php

namespace App\Imports;

use App\Models\ProgresKnmpNasional;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ProgresKnmpNasionalImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public $failures = [];
    public $successCount = 0;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
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
                // 3. Update or Create
                ProgresKnmpNasional::updateOrCreate(
                    ['knmp_id' => $knmpId],
                    ['progres' => $progresValue]
                );
                $this->successCount++;
            } catch (\Exception $e) {
                $this->failures[] = "Baris {$rowNumber}: Gagal menyimpan database. " . $e->getMessage();
            }
        }
    }
}
