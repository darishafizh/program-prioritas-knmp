<?php

namespace App\Imports;

use App\Models\InformasiPendapatanRumahTangga;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Row;

class InformasiPendapatanRumahTanggaImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents
{
    protected $knmpId;

    /**
     * Required columns for this import type
     */
    protected $requiredColumns = [
        'responden_id',
        'pendapatan_perikanan',
        'pendapatan_total',
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
                        "File Excel tidak sesuai dengan format Pendapatan Rumah Tangga. " .
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
        InformasiPendapatanRumahTangga::updateOrCreate(
            [
                'knmp_id' => $this->knmpId,
                'responden_id' => $row['responden_id'] ?? null,
            ],
            [
                'pendapatan_perikanan' => $row['pendapatan_perikanan'] ?? null,
                'pendapatan_non_perikanan' => $row['pendapatan_non_perikanan'] ?? null,
                'pendapatan_total' => $row['pendapatan_total'] ?? null,
                'kontribusi_nelayan_persen' => $row['kontribusi_nelayan_persen'] ?? null,
                'jumlah_sumber_penghasilan' => $row['jumlah_sumber_penghasilan'] ?? null,
                'ketergantungan_perikanan' => $row['ketergantungan_perikanan'] ?? null,
                'stabilitas_pendapatan' => $row['stabilitas_pendapatan'] ?? null,
                'keterlibatan_perempuan' => $row['keterlibatan_perempuan'] ?? null,
                'kontribusi_perempuan_persen' => $row['kontribusi_perempuan_persen'] ?? null,
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
