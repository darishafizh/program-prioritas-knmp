<?php

namespace App\Exports;

use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InformasiUsahaTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    protected $respondenIds;

    public function __construct($respondenIds = null)
    {
        $this->respondenIds = $respondenIds;
    }

    public function array(): array
    {
        if (empty($this->respondenIds)) {
            return [];
        }

        $respondents = InformasiResponden::whereIn('id', $this->respondenIds)
            ->orderBy('id')
            ->get(['id', 'nama_responden']);

        return $respondents->map(function ($responden) {
            return [
                $responden->id,
                '', // nama_kapal
                '', // tahun_pembuatan
                '', // ukuran_gt
                '', // dimensi_perahu
                '', // jenis_bahan_baku
                '', // jenis_mesin
                '', // alat_penyimpanan
                '', // jenis_alat_tangkap
                '', // hari_per_trip
                '', // waktu_melaut_jam
                '', // jarak_penangkapan_mil
                '', // waktu_tempuh_jam
                '', // jml_trip_per_bulan
                '', // jml_bulan_melaut
                '', // produksi_kg_per_trip
                '', // penjualan_rp_per_trip
                '', // biaya_solar_rp
                '', // volume_solar_liter
                '', // biaya_bensin_rp
                '', // volume_bensin_liter
                '', // biaya_es_balok_rp
                '', // volume_es_balok
                '', // biaya_es_kantong_rp
                '', // volume_es_kantong
                '', // total_biaya_operasional
                '', // ikan_1_jenis
                '', // ikan_1_kg_trip
                '', // ikan_1_persen
                '', // ikan_2_jenis
                '', // ikan_2_kg_trip
                '', // ikan_2_persen
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'responden_id',
            'nama_kapal',
            'tahun_pembuatan',
            'ukuran_gt',
            'dimensi_perahu',
            'jenis_bahan_baku',
            'jenis_mesin',
            'alat_penyimpanan',
            'jenis_alat_tangkap',
            'hari_per_trip',
            'waktu_melaut_jam',
            'jarak_penangkapan_mil',
            'waktu_tempuh_jam',
            'jml_trip_per_bulan',
            'jml_bulan_melaut',
            'produksi_kg_per_trip',
            'penjualan_rp_per_trip',
            'biaya_solar_rp',
            'volume_solar_liter',
            'biaya_bensin_rp',
            'volume_bensin_liter',
            'biaya_es_balok_rp',
            'volume_es_balok',
            'biaya_es_kantong_rp',
            'volume_es_kantong',
            'total_biaya_operasional',
            'ikan_1_jenis',
            'ikan_1_kg_trip',
            'ikan_1_persen',
            'ikan_2_jenis',
            'ikan_2_kg_trip',
            'ikan_2_persen',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '6C757D'],
                ],
            ],
        ];
    }

    /**
     * Register events to add data validation (dropdowns)
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $rowCount = 1000;

                // Validation Options
                $bahanBakuOptions = '"Fiber,Kayu Laminasi,Kayu,Besi,Lainnya"';
                $jenisMesinOptions = '"Motor Tempel Pribadi,Motor Tempel Bantuan,Sampan (tanpa motor)"';
                $alatPenyimpananOptions = '"Coolbox,Palka,Stereofoam Box,Tong plastik,Lainnya"';
                $alatTangkapOptions = '"Handline/Pancing Ulur,Rawai Dasar,Pancing Dasar,Jaring Insang/Gillnett,Pole and Line,Purse Seine,Lainnya"';

                // F: Jenis Bahan Baku
                $this->addValidation($sheet, 'F2:F' . $rowCount, $bahanBakuOptions);

                // G: Jenis Mesin
                $this->addValidation($sheet, 'G2:G' . $rowCount, $jenisMesinOptions);

                // H: Alat Penyimpanan
                $this->addValidation($sheet, 'H2:H' . $rowCount, $alatPenyimpananOptions);

                // I: Jenis Alat Tangkap
                $this->addValidation($sheet, 'I2:I' . $rowCount, $alatTangkapOptions);
            },
        ];
    }

    private function addValidation($sheet, $cellRange, $formula)
    {
        $validation = $sheet->getCell(explode(':', $cellRange)[0])->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Input Error');
        $validation->setError('Nilai tidak valid.');
        $validation->setPromptTitle('Pilih Data');
        $validation->setPrompt('Silakan pilih dari daftar.');
        $validation->setFormula1($formula);

        // Apply to range
        $sheet->setDataValidation($cellRange, $validation);
    }
}
