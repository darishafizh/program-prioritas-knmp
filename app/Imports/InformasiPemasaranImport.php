<?php

namespace App\Imports;

use App\Models\InformasiPemasaran;
use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Row;
use App\Models\DetailPemasaranIkan;

class InformasiPemasaranImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents
{
    protected $knmpId;

    /**
     * Required columns for this import type
     */
    protected $requiredColumns = [
        'nama_responden',
        'kendala_pemasaran_text',
        'cara_penanganan_ikan',
        'eceran_kg',
        'koperasi_kg',
        'tengkulak_kg',
        'pengepul_kg',
        'pedagang_besar_kg',
        'lainnya_kg',
        'lainnya_keterangan',
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
                        "File Excel tidak sesuai dengan format Informasi Pemasaran. " .
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

        // 1. Create or Update parent: InformasiPemasaran
        $informasiPemasaran = InformasiPemasaran::updateOrCreate(
            [
                'knmp_id'      => $this->knmpId,
                'responden_id' => $respondenId,
            ],
            [
                'kendala_pemasaran_text' => $row['kendala_pemasaran_text'] ?? null,
                'cara_penanganan_ikan'   => $row['cara_penanganan_ikan'] ?? null,
            ]
        );

        // 2. Create or Update child: DetailPemasaranIkan
        DetailPemasaranIkan::updateOrCreate(
            [
                'pemasaran_id' => $informasiPemasaran->id,
            ],
            [
                'responden_id'       => $respondenId,
                'eceran_kg'          => $row['eceran_kg'] ?? 0,
                'koperasi_kg'        => $row['koperasi_kg'] ?? 0,
                'tengkulak_kg'       => $row['tengkulak_kg'] ?? 0,
                'pengepul_kg'        => $row['pengepul_kg'] ?? 0,
                'pedagang_besar_kg'  => $row['pedagang_besar_kg'] ?? 0,
                'lainnya_kg'         => $row['lainnya_kg'] ?? 0,
                'lainnya_keterangan' => $row['lainnya_keterangan'] ?? null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nama_responden'    => 'required',
            'eceran_kg'         => 'nullable|numeric',
            'koperasi_kg'       => 'nullable|numeric',
            'tengkulak_kg'      => 'nullable|numeric',
            'pengepul_kg'       => 'nullable|numeric',
            'pedagang_besar_kg' => 'nullable|numeric',
            'lainnya_kg'        => 'nullable|numeric',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama_responden.required' => 'Kolom "nama_responden" wajib diisi pada baris :attribute.',
        ];
    }
}
