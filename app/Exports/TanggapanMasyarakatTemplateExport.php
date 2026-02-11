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
                $responden->id,
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
            'responden_id',
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
                    // Column C: kesesuaian_kebutuhan dropdown
                    $valC = $sheet->getCell("C{$row}")->getDataValidation();
                    $valC->setType(DataValidation::TYPE_LIST);
                    $valC->setErrorStyle(DataValidation::STYLE_STOP);
                    $valC->setAllowBlank(false);
                    $valC->setShowInputMessage(true);
                    $valC->setShowErrorMessage(true);
                    $valC->setShowDropDown(true);
                    $valC->setErrorTitle('Input tidak valid');
                    $valC->setError('Pilih: Ya, sesuai atau Tidak sesuai');
                    $valC->setPromptTitle('Kesesuaian Kebutuhan');
                    $valC->setPrompt('Pilih apakah rencana pembangunan sesuai kebutuhan masyarakat.');
                    $valC->setFormula1($kesesuaianOptions);

                    // Column E: tingkat_kesenangan dropdown
                    $valE = $sheet->getCell("E{$row}")->getDataValidation();
                    $valE->setType(DataValidation::TYPE_LIST);
                    $valE->setErrorStyle(DataValidation::STYLE_STOP);
                    $valE->setAllowBlank(false);
                    $valE->setShowInputMessage(true);
                    $valE->setShowErrorMessage(true);
                    $valE->setShowDropDown(true);
                    $valE->setErrorTitle('Input tidak valid');
                    $valE->setError('Pilih: Senang, Biasa saja, atau Tidak Senang');
                    $valE->setPromptTitle('Tingkat Kesenangan');
                    $valE->setPrompt('Pilih tingkat kesenangan terhadap rencana pembangunan KNMP.');
                    $valE->setFormula1($kesenanganOptions);
                }

                // Protect pre-filled columns (A-B) with light gray background
                $sheet->getStyle("A2:B{$lastRow}")->getFill()->setFillType(
                    \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                );
                $sheet->getStyle("A2:B{$lastRow}")->getFill()->getStartColor()->setRGB('F2F2F2');

                // Highlight dropdown columns with green header
                foreach (['C1', 'E1'] as $cell) {
                    $sheet->getStyle($cell)->getFill()->setFillType(
                        \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                    );
                    $sheet->getStyle($cell)->getFill()->getStartColor()->setRGB('70AD47');
                }

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(14);
                $sheet->getColumnDimension('B')->setWidth(25);
                $sheet->getColumnDimension('C')->setWidth(22);
                $sheet->getColumnDimension('D')->setWidth(30);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(30);
                $sheet->getColumnDimension('G')->setWidth(30);
                $sheet->getColumnDimension('H')->setWidth(30);
            },
        ];
    }
}
