<?php

namespace App\Imports;

use App\Models\ProgresHarian;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProgresHarianImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithCalculatedFormulas
{
    public $failures = [];
    public $successCount = 0;
    public $duplicateCount = 0;
    public $notFoundCount = 0;
    public $emptyCount = 0;
    public $errorCount = 0;

    /**
     * Get total failure count
     */
    public function totalFailures()
    {
        return $this->duplicateCount + $this->notFoundCount + $this->emptyCount + $this->errorCount;
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
            $rowNumber = $index + 2;

            if (empty($row['knmp_id'])) {
                $this->emptyCount++;
                continue;
            }

            $knmpId = (int) $row['knmp_id'];

            if (!in_array($knmpId, $existingKnmpIds)) {
                $this->notFoundCount++;
                continue;
            }

            // Handle date parsing from Excel
            $tanggal = null;
            if (isset($row['tanggal_progres']) && $row['tanggal_progres'] !== '') {
                try {
                    if (is_numeric($row['tanggal_progres'])) {
                        $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_progres'])->format('Y-m-d');
                    } else {
                        $tanggal = \Carbon\Carbon::parse($row['tanggal_progres'])->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $this->errorCount++;
                    Log::error("Import Progres Harian - Baris {$rowNumber}: Format tanggal tidak valid");
                    continue; // Skip this row if date is invalid
                }
            } else {
                $this->errorCount++;
                Log::error("Import Progres Harian - Baris {$rowNumber}: Tanggal progres kosong");
                continue; // Skip if date is empty
            }

            $progresValue = $row['progres'] ?? 0;
            if (is_string($progresValue)) {
                $progresValue = str_replace(',', '.', $progresValue);
            }
            $progresValue = (float) $progresValue;

            try {
                ProgresHarian::updateOrCreate(
                    [
                        'knmp_id' => $knmpId,
                        'tanggal' => $tanggal
                    ],
                    [
                        'progres' => $progresValue,
                        'keterangan' => $row['keterangan'] ?? null,
                    ]
                );
                $this->successCount++;
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error("Import Progres Harian - Baris {$rowNumber}", ['error' => $e->getMessage()]);
                $errorCode = $e->errorInfo[1] ?? null;
                if ($errorCode == 1062) {
                    $this->duplicateCount++;
                } else {
                    $this->errorCount++;
                }
            } catch (\Exception $e) {
                Log::error("Import Progres Harian - Baris {$rowNumber}", ['error' => $e->getMessage()]);
                $this->errorCount++;
            }
        }
    }
}
