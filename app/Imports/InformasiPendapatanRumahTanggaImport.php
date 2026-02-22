<?php

namespace App\Imports;

use App\Models\InformasiPendapatanRumahTangga;
use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Row;

class InformasiPendapatanRumahTanggaImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents, WithCalculatedFormulas
{
    protected $knmpId;

    /**
     * Required columns for this import type
     */
    protected $requiredColumns = [
        'nama_responden',
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

        // Cari responden berdasarkan nama dan knmp_id
        $namaResponden = trim($row['nama_responden'] ?? '');
        if (empty($namaResponden)) {
            return;
        }

        $responden = InformasiResponden::where('knmp_id', $this->knmpId)
            ->where('nama_responden', $namaResponden)
            ->first();

        if (!$responden) {
            $responden = InformasiResponden::where('knmp_id', $this->knmpId)
                ->whereRaw('LOWER(nama_responden) = ?', [strtolower($namaResponden)])
                ->first();
        }

        if (!$responden) {
            return;
        }

        $respondenId = $responden->id;

        // Baca nilai numerik kolom B, C, D
        // WithCalculatedFormulas memastikan formula =B+C di kolom D sudah dihitung
        $pendapatanPerikanan    = is_numeric($row['pendapatan_perikanan'] ?? null)
            ? (float) $row['pendapatan_perikanan'] : 0;
        $pendapatanNonPerikanan = is_numeric($row['pendapatan_non_perikanan'] ?? null)
            ? (float) $row['pendapatan_non_perikanan'] : 0;

        // Gunakan nilai formula jika tersedia, fallback ke penjumlahan manual
        $pendapatanTotal = is_numeric($row['pendapatan_total'] ?? null)
            ? (float) $row['pendapatan_total']
            : ($pendapatanPerikanan + $pendapatanNonPerikanan);

        // Helper to map text answers to scores
        $getScore = function ($type, $value) {
            if (is_null($value)) return null;
            if (is_numeric($value)) return (int) $value;

            $val = strtolower(trim($value));

            if ($type === 'kontribusi_nelayan') {
                if (str_contains($val, '100%')) return 4;
                if (str_contains($val, 'lebih dari 80')) return 3;
                if (str_contains($val, '50-80')) return 2;
                if (str_contains($val, '50–80')) return 2;
                if (str_contains($val, 'kurang dari 50')) return 1;
            }
            if ($type === 'jumlah_sumber') {
                if (str_contains($val, 'lebih dari 3')) return 4;
                if (str_contains($val, '3 sumber')) return 3;
                if (str_contains($val, '2 sumber')) return 2;
                if (str_contains($val, '1 (hanya')) return 1;
            }
            if ($type === 'ketergantungan') {
                if (str_contains($val, 'sangat bergantung')) return 4;
                if (str_contains($val, 'cukup bergantung')) return 3;
                if (str_contains($val, 'sedikit bergantung')) return 2;
                if (str_contains($val, 'tidak bergantung')) return 1;
            }
            if ($type === 'stabilitas') {
                if (str_contains($val, 'stabil sepanjang')) return 4;
                if (str_contains($val, 'cenderung stabil')) return 3;
                if (str_contains($val, 'sangat tidak stabil')) return 1;
                if (str_contains($val, 'tidak stabil')) return 2;
            }
            if ($type === 'keterlibatan_perempuan') {
                if ($val === 'selalu') return 4;
                if ($val === 'sering') return 3;
                if ($val === 'jarang') return 2;
                if (str_contains($val, 'tidak pernah')) return 1;
            }
            if ($type === 'kontribusi_perempuan') {
                if (str_contains($val, 'lebih dari 75')) return 5;
                if (str_contains($val, '51%–75') || str_contains($val, '51%-75')) return 4;
                if (str_contains($val, '25%–50') || str_contains($val, '25%-50')) return 3;
                if (str_contains($val, 'kurang dari 25')) return 2;
                if (str_contains($val, 'tidak dilibatkan')) return 1;
            }
            return 0;
        };

        // Use updateOrCreate to prevent duplicates on re-import
        InformasiPendapatanRumahTangga::updateOrCreate(
            [
                'knmp_id'      => $this->knmpId,
                'responden_id' => $respondenId,
            ],
            [
                'pendapatan_perikanan'        => $pendapatanPerikanan ?: null,
                'pendapatan_non_perikanan'    => $pendapatanNonPerikanan ?: null,
                'pendapatan_total'            => $pendapatanTotal ?: null,
                'kontribusi_nelayan_persen'   => $getScore('kontribusi_nelayan', $row['kontribusi_nelayan_persen'] ?? null),
                'jumlah_sumber_penghasilan'   => $getScore('jumlah_sumber', $row['jumlah_sumber_penghasilan'] ?? null),
                'ketergantungan_perikanan'    => $getScore('ketergantungan', $row['ketergantungan_perikanan'] ?? null),
                'stabilitas_pendapatan'       => $getScore('stabilitas', $row['stabilitas_pendapatan'] ?? null),
                'keterlibatan_perempuan'      => $getScore('keterlibatan_perempuan', $row['keterlibatan_perempuan'] ?? null),
                'kontribusi_perempuan_persen' => $getScore('kontribusi_perempuan', $row['kontribusi_perempuan_persen'] ?? null),
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nama_responden' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama_responden.required' => 'Kolom "nama_responden" wajib diisi pada baris :attribute.',
            'nama_responden.exists'   => 'Responden pada baris :attribute tidak ditemukan di database.',
        ];
    }
}
