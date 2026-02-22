<?php

namespace App\Imports;

use App\Models\InformasiUsaha;
use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Row;
use App\Models\InformasiUsahaIkan;

class InformasiUsahaImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents
{
    protected $knmpId;

    /**
     * Required columns for this import type
     */
    protected $requiredColumns = [
        'nama_responden',
        'nama_kapal',
        'jenis_alat_tangkap',
        'ikan_1_jenis',
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
                        "File Excel tidak sesuai dengan format Informasi Usaha. " .
                        "Kolom yang diperlukan tidak ditemukan: " . implode(', ', $missingColumns) . ". " .
                        "Pastikan Anda menggunakan template yang benar."
                    );
                }
            },
        ];
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

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

        // Helper to map text answers to scores
        $getScore = function($type, $value) {
            if (is_null($value)) return null;
            if (is_numeric($value)) return (int) $value;

            $val = strtolower(trim($value));

            if ($type === 'jenis_bahan_baku') {
                if ($val === 'fiber') return 4;
                if ($val === 'kayu laminasi') return 3;
                if ($val === 'kayu') return 2;
                if ($val === 'besi') return 1;
                if ($val === 'lainnya') return 1;
            }

            if ($type === 'jenis_mesin') {
                if ($val === 'motor tempel pribadi') return 4;
                if ($val === 'motor tempel bantuan') return 3;
                if (str_contains($val, 'sampan')) return 1;
            }

            if ($type === 'alat_penyimpanan') {
                if ($val === 'coolbox') return 4;
                if ($val === 'palka') return 3;
                if (str_contains($val, 'stereofoam')) return 2;
                if (str_contains($val, 'tong')) return 1;
                if ($val === 'lainnya') return 1;
            }
            return 0;
        };

        // 1. Create or Update parent: InformasiUsaha
        $informasiUsaha = InformasiUsaha::updateOrCreate(
            [
                'knmp_id'      => $this->knmpId,
                'responden_id' => $respondenId,
            ],
            [
                'nama_kapal'              => $row['nama_kapal'] ?? null,
                'tahun_pembuatan'         => $row['tahun_pembuatan'] ?? null,
                'ukuran_gt'               => $row['ukuran_gt'] ?? null,
                'dimensi_perahu'          => $row['dimensi_perahu'] ?? null,
                'jenis_bahan_baku'        => $getScore('jenis_bahan_baku', $row['jenis_bahan_baku'] ?? null),
                'jenis_mesin'             => $getScore('jenis_mesin', $row['jenis_mesin'] ?? null),
                'alat_penyimpanan'        => $getScore('alat_penyimpanan', $row['alat_penyimpanan'] ?? null),
                'jenis_alat_tangkap'      => $row['jenis_alat_tangkap'] ?? null,
                'hari_per_trip'           => $row['hari_per_trip'] ?? null,
                'waktu_melaut_jam'        => $row['waktu_melaut_jam'] ?? null,
                'jarak_penangkapan_mil'   => $row['jarak_penangkapan_mil'] ?? null,
                'waktu_tempuh_jam'        => $row['waktu_tempuh_jam'] ?? null,
                'jml_trip_per_bulan'      => $row['jml_trip_per_bulan'] ?? null,
                'jml_bulan_melaut'        => $row['jml_bulan_melaut'] ?? null,
                'produksi_kg_per_trip'    => $row['produksi_kg_per_trip'] ?? null,
                'penjualan_rp_per_trip'   => $row['penjualan_rp_per_trip'] ?? null,
                'biaya_solar_rp'          => $row['biaya_solar_rp'] ?? null,
                'volume_solar_liter'      => $row['volume_solar_liter'] ?? null,
                'biaya_bensin_rp'         => $row['biaya_bensin_rp'] ?? null,
                'volume_bensin_liter'     => $row['volume_bensin_liter'] ?? null,
                'biaya_es_balok_rp'       => $row['biaya_es_balok_rp'] ?? null,
                'volume_es_balok'         => $row['volume_es_balok'] ?? null,
                'biaya_es_kantong_rp'     => $row['biaya_es_kantong_rp'] ?? null,
                'volume_es_kantong'       => $row['volume_es_kantong'] ?? null,
                'total_biaya_operasional' => $row['total_biaya_operasional'] ?? null,
            ]
        );

        // 2. Create or Update child: InformasiUsahaIkan
        for ($i = 1; $i <= 2; $i++) {
            $jenisKey  = "ikan_{$i}_jenis";
            $kgTripKey = "ikan_{$i}_kg_trip";
            $persenKey = "ikan_{$i}_persen";

            if (!empty($row[$jenisKey])) {
                InformasiUsahaIkan::updateOrCreate(
                    [
                        'informasi_usaha_id' => $informasiUsaha->id,
                        'responden_id'       => $respondenId,
                        'jenis'              => $row[$jenisKey],
                    ],
                    [
                        'kg_trip' => $row[$kgTripKey] ?? 0,
                        'persen'  => $row[$persenKey] ?? 0,
                    ]
                );
            }
        }
    }

    public function rules(): array
    {
        return [
            'nama_responden'       => 'required',
            'produksi_kg_per_trip' => 'nullable|numeric',
            'penjualan_rp_per_trip' => 'nullable|numeric',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama_responden.required' => 'Kolom "nama_responden" wajib diisi pada baris :attribute.',
        ];
    }
}
