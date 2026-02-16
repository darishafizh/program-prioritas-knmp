<?php

namespace App\Exports;

use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class SosialKelembagaanTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    protected $respondenIds;

    public function __construct($respondenIds = null)
    {
        $this->respondenIds = $respondenIds;
    }

    public function array(): array
    {
        if (empty($this->respondenIds)) {
            // Default empty rows if no responden selected (for blank template)
            return [
                ['1', '', '', '', '', '', '', '', '', '', '', '', ''],
                ['2', '', '', '', '', '', '', '', '', '', '', '', ''],
            ];
        }

        $respondents = InformasiResponden::whereIn('id', $this->respondenIds)
            ->orderBy('id')
            ->get(['id', 'nama_responden']);

        return $respondents->map(function ($responden) {
            return [
                $responden->id,
                '', // anggota_kelompok
                '', // manfaat_kelompok
                '', // anggota_koperasi
                '', // tertarik_koperasi
                '', // manfaat_koperasi
                '', // koperasi_rapat_tahunan
                '', // koperasi_partisipasi_aktif
                '', // koperasi_pengurus_kompeten
                '', // koperasi_transparan
                '', // koperasi_keuangan_sehat
                '', // koperasi_jaringan_pasar
                '', // koperasi_kepercayaan_usaha
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'responden_id',
            'anggota_kelompok',
            'manfaat_kelompok',
            'anggota_koperasi',
            'tertarik_koperasi',
            'manfaat_koperasi',
            'koperasi_rapat_tahunan',
            'koperasi_partisipasi_aktif',
            'koperasi_pengurus_kompeten',
            'koperasi_transparan',
            'koperasi_keuangan_sehat',
            'koperasi_jaringan_pasar',
            'koperasi_kepercayaan_usaha',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E83E8C'],
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
                $rowCount = 1000; // Apply validation to 1000 rows

                // Validation Options
                $keanggotaanOptions = '"Ya, sangat aktif,Ya, tidak aktif,Tidak pernah bergabung,Tidak ada kelompok nelayan/KUB di lokasi saya,Tidak ada koperasi perikanan di lokasi saya"';
                $manfaatOptions = '"Sangat Setuju,Setuju,Cukup Setuju,Kurang Setuju,Tidak Setuju"';
                $tertarikOptions = '"Sangat tidak tertarik,Tidak tertarik,Tertarik,Sudah menjadi anggota"';
                $yaTidakOptions = '"Ya,Tidak"';

                // Column B: Anggota Kelompok
                $this->addValidation($sheet, 'B2:B' . $rowCount, $keanggotaanOptions);
                
                // Column C: Manfaat Kelompok
                $this->addValidation($sheet, 'C2:C' . $rowCount, $manfaatOptions);

                // Column D: Anggota Koperasi
                $this->addValidation($sheet, 'D2:D' . $rowCount, $keanggotaanOptions);

                // Column E: Tertarik Koperasi
                $this->addValidation($sheet, 'E2:E' . $rowCount, $tertarikOptions);

                // Column F: Manfaat Koperasi
                $this->addValidation($sheet, 'F2:F' . $rowCount, $manfaatOptions);

                // Column G-M: Sub-questions (Ya/Tidak)
                $columns = ['G', 'H', 'I', 'J', 'K', 'L', 'M'];
                foreach ($columns as $col) {
                    $this->addValidation($sheet, $col . '2:' . $col . $rowCount, $yaTidakOptions);
                }
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
