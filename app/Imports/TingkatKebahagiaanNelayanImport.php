<?php

namespace App\Imports;

use App\Models\TingkatKebahagiaanNelayan;
use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;

class TingkatKebahagiaanNelayanImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents
{
    protected $knmpId;

    /**
     * Required columns for this import type
     */
    protected $requiredColumns = [
        'responden_id',
        'nomor_soal',
        'kategori',
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
                        "File Excel tidak sesuai dengan format Tingkat Kebahagiaan Nelayan. " .
                        "Kolom yang diperlukan tidak ditemukan: " . implode(', ', $missingColumns) . ". " .
                        "Pastikan Anda menggunakan template yang benar."
                    );
                }
            },
        ];
    }

    public function model(array $row)
    {
        // Lookup responden_id if it's a name string
        $respondenId = $this->lookupRespondenId($row['responden_id'] ?? null);

        // Convert skor_nilai from text or formula to numeric
        $skorNilai = $this->convertSkorNilai($row['skor_nilai'] ?? $row['jawaban_teks'] ?? null);

        return new TingkatKebahagiaanNelayan([
            'knmp_id' => $this->knmpId,
            'responden_id' => $respondenId,
            'nomor_soal' => $row['nomor_soal'] ?? null,
            'kategori' => $row['kategori'] ?? null,
            'jawaban_teks' => $row['jawaban_teks'] ?? null,
            'skor_nilai' => $skorNilai,
        ]);
    }

    /**
     * Lookup responden ID from name or return as-is if already numeric
     */
    protected function lookupRespondenId($value)
    {
        if (empty($value))
            return null;
        if (is_numeric($value))
            return (int) $value;

        // Try to find responden by name
        $responden = InformasiResponden::where('knmp_id', $this->knmpId)
            ->where('nama_responden', 'LIKE', '%' . trim($value) . '%')
            ->first();
        return $responden ? $responden->id : null;
    }

    /**
     * Convert text answer to numeric score
     */
    protected function convertSkorNilai($value)
    {
        if (empty($value))
            return null;
        if (is_numeric($value))
            return (int) $value;

        // If it's a formula string, extract the answer text
        $value = trim($value);

        // Map text answers to numeric scores
        $textToScore = [
            'Sangat Setuju' => 5,
            'Setuju' => 4,
            'Netral' => 3,
            'Tidak Setuju' => 2,
            'Sangat Tidak Setuju' => 1,
            // Alternative mappings
            'Sangat Senang' => 5,
            'Senang' => 4,
            'Biasa Saja' => 3,
            'Tidak Senang' => 2,
            'Sangat Tidak Senang' => 1,
        ];

        // Check if value matches any key (case-insensitive)
        foreach ($textToScore as $text => $score) {
            if (stripos($value, $text) !== false) {
                return $score;
            }
        }

        return null;
    }

    public function rules(): array
    {
        return [
            'nomor_soal' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nomor_soal.required' => 'Kolom "nomor_soal" wajib diisi pada baris :attribute',
        ];
    }
}
