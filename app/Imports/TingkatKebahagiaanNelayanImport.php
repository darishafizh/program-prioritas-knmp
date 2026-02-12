<?php

namespace App\Imports;

use App\Models\TingkatKebahagiaanNelayan;
use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Row;

class TingkatKebahagiaanNelayanImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents
{
    protected $knmpId;

    /**
     * Required columns for this import type.
     */
    protected $requiredColumns = [
        'responden_id',
        'nomor_soal',
        'kategori',
    ];

    /**
     * Mapping from text answer to numeric score
     */
    protected static $textToScore = [
        'sangat setuju' => 5,
        'setuju' => 4,
        'netral' => 3,
        'tidak setuju' => 2,
        'sangat tidak setuju' => 1,
        // Alternative mappings
        'sangat senang' => 5,
        'senang' => 4,
        'biasa saja' => 3,
        'tidak senang' => 2,
        'sangat tidak senang' => 1,
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

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        // Lookup responden_id if it's a name string
        $respondenId = $this->lookupRespondenId($row['responden_id'] ?? null);

        // Get jawaban_teks from the row
        $jawabanTeks = trim($row['jawaban_teks'] ?? '');

        // Convert jawaban_teks to numeric score
        // Priority: jawaban_teks → skor_nilai (for backward compatibility)
        $skorNilai = $this->convertSkorNilai($jawabanTeks);
        if ($skorNilai === null && isset($row['skor_nilai'])) {
            $skorNilai = $this->convertSkorNilai($row['skor_nilai']);
        }

        // Use updateOrCreate to prevent duplicates on re-import
        TingkatKebahagiaanNelayan::updateOrCreate(
            [
                'knmp_id' => $this->knmpId,
                'responden_id' => $respondenId,
                'nomor_soal' => $row['nomor_soal'] ?? null,
            ],
            [
                'kategori' => $row['kategori'] ?? null,
                'jawaban_teks' => !empty($jawabanTeks) ? $jawabanTeks : ($row['jawaban_teks'] ?? null),
                'skor_nilai' => $skorNilai,
            ]
        );
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
     * Convert text answer to numeric score.
     * Accepts both text labels and numeric values.
     */
    protected function convertSkorNilai($value)
    {
        if (empty($value) && $value !== 0 && $value !== '0')
            return null;

        // If already numeric (1-5), return directly
        if (is_numeric($value)) {
            $num = (int) $value;
            return ($num >= 1 && $num <= 5) ? $num : null;
        }

        // Normalize to lowercase and trim
        $normalized = strtolower(trim($value));

        // Exact match first (more reliable)
        if (isset(self::$textToScore[$normalized])) {
            return self::$textToScore[$normalized];
        }

        // Partial match as fallback (order matters: longest match first)
        $orderedKeys = [
            'sangat tidak setuju', 'sangat tidak senang',
            'sangat setuju', 'sangat senang',
            'tidak setuju', 'tidak senang',
            'biasa saja', 'netral',
            'setuju', 'senang',
        ];

        foreach ($orderedKeys as $text) {
            if (strpos($normalized, $text) !== false) {
                return self::$textToScore[$text];
            }
        }

        return null;
    }

    public function rules(): array
    {
        return [
            'responden_id' => 'required',
            'nomor_soal' => 'required',
            'jawaban_teks' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'responden_id.required' => 'Kolom "responden_id" wajib diisi pada baris :attribute.',
            'nomor_soal.required' => 'Kolom "nomor_soal" wajib diisi pada baris :attribute',
            'jawaban_teks.required' => 'Kolom "jawaban_teks" wajib diisi pada baris :attribute. Pilih: Sangat Tidak Setuju, Tidak Setuju, Netral, Setuju, atau Sangat Setuju.',
        ];
    }
}
