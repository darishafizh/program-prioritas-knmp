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

class TanggapanMasyarakatTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
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
                $responden->nama_responden,
                '', // kesesuaian_kebutuhan — dropdown
                '', // item_tidak_sesuai
                '', // tingkat_kesenangan — dropdown
                '', // alasan_tidak_senang
                '', // harapan_masyarakat
                '', // masukan_saran_perbaikan
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'nama_responden',
            'kesesuaian_kebutuhan',
            'item_tidak_sesuai',
            'tingkat_kesenangan',
            'alasan_tidak_senang',
            'harapan_masyarakat',
            'masukan_saran_perbaikan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFC107'],
                ],
            ],
        ];
    }

    /**
     * Add dropdown data validation for kesesuaian_kebutuhan and tingkat_kesenangan columns
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $dataCount = count($this->array());
                $lastRow = $dataCount + 1; // +1 for header

                if ($lastRow < 2) return;

                // Dropdown options
                $kesesuaianOptions = '"Ya, sesuai,Tidak sesuai"';
                $kesenanganOptions = '"Senang,Biasa saja,Tidak Senang"';

                for ($row = 2; $row <= $lastRow; $row++) {
                    // Column B: kesesuaian_kebutuhan dropdown
                    $valB = $sheet->getCell("B{$row}")->getDataValidation();
                    $valB->setType(DataValidation::TYPE_LIST);
                    $valB->setErrorStyle(DataValidation::STYLE_STOP);
                    $valB->setAllowBlank(false);
                    $valB->setShowInputMessage(true);
                    $valB->setShowErrorMessage(true);
                    $valB->setShowDropDown(true);
                    $valB->setErrorTitle('Input tidak valid');
                    $valB->setError('Pilih: Ya, sesuai atau Tidak sesuai');
                    $valB->setPromptTitle('Kesesuaian Kebutuhan');
                    $valB->setPrompt('Pilih apakah rencana pembangunan sesuai kebutuhan masyarakat.');
                    $valB->setFormula1($kesesuaianOptions);

                    // Column D: tingkat_kesenangan dropdown
                    $valD = $sheet->getCell("D{$row}")->getDataValidation();
                    $valD->setType(DataValidation::TYPE_LIST);
                    $valD->setErrorStyle(DataValidation::STYLE_STOP);
                    $valD->setAllowBlank(false);
                    $valD->setShowInputMessage(true);
                    $valD->setShowErrorMessage(true);
                    $valD->setShowDropDown(true);
                    $valD->setErrorTitle('Input tidak valid');
                    $valD->setError('Pilih: Senang, Biasa saja, atau Tidak Senang');
                    $valD->setPromptTitle('Tingkat Kesenangan');
                    $valD->setPrompt('Pilih tingkat kesenangan terhadap rencana pembangunan KNMP.');
                    $valD->setFormula1($kesenanganOptions);
                }

                // Protect pre-filled column (A) with light gray background
                $sheet->getStyle("A2:A{$lastRow}")->getFill()->setFillType(
                    \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                );
                $sheet->getStyle("A2:A{$lastRow}")->getFill()->getStartColor()->setRGB('F2F2F2');

                // Highlight dropdown columns with green header
                foreach (['B1', 'D1'] as $cell) {
                    $sheet->getStyle($cell)->getFill()->setFillType(
                        \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                    );
                    $sheet->getStyle($cell)->getFill()->getStartColor()->setRGB('70AD47');
                }

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(25);
                $sheet->getColumnDimension('B')->setWidth(22);
                $sheet->getColumnDimension('C')->setWidth(30);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(30);
                $sheet->getColumnDimension('F')->setWidth(30);
                $sheet->getColumnDimension('G')->setWidth(30);
            },
        ];
    }
}
