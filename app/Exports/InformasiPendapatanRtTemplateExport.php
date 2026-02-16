<?php

namespace App\Exports;

use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class InformasiPendapatanRtTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    protected $respondenIds;

    public function __construct($respondenIds = null)
    {
        $this->respondenIds = $respondenIds;
    }

    public function array(): array
    {
        if (empty($this->respondenIds)) {
             return [
                ['1', '', '', '', '', '', '', '', '', ''],
                ['2', '', '', '', '', '', '', '', '', ''],
            ];
        }

        $respondents = InformasiResponden::whereIn('id', $this->respondenIds)
            ->orderBy('id')
            ->get(['id', 'nama_responden']);

        return $respondents->map(function ($responden) {
            return [
                $responden->id,
                '', // pendapatan_perikanan
                '', // pendapatan_non_perikanan
                '', // pendapatan_total
                '', // kontribusi_nelayan_persen
                '', // jumlah_sumber_penghasilan
                '', // ketergantungan_perikanan
                '', // stabilitas_pendapatan
                '', // keterlibatan_perempuan
                '', // kontribusi_perempuan_persen
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'responden_id',
            'pendapatan_perikanan',
            'pendapatan_non_perikanan',
            'pendapatan_total',
            'kontribusi_nelayan_persen',
            'jumlah_sumber_penghasilan',
            'ketergantungan_perikanan',
            'stabilitas_pendapatan',
            'keterlibatan_perempuan',
            'kontribusi_perempuan_persen',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '20C997'],
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
                $kontribusiNelayanOptions = '"Kurang dari 50%,50-80%,Lebih dari 80%,100% (satu-satunya sumber pendapatan)"';
                $jumlahSumberOptions = '"1 (hanya satu sumber) dari nelayan,2 sumber,3 sumber,Lebih dari 3 sumber"';
                $ketergantunganOptions = '"Sangat bergantung,Cukup bergantung,Sedikit bergantung,Tidak bergantung"';
                $stabilitasOptions = '"Stabil sepanjang tahun,Cenderung stabil,Tidak stabil,Sangat tidak stabil"';
                $keterlibatanOptions = '"Selalu,Sering,Jarang,Tidak pernah"';
                $kontribusiPrOptions = '"Lebih dari 75%,51%–75%,25%–50%,Kurang dari 25%,Perempuan tidak dilibatkan dalam kegiatan ekonomi rumah tangga"';

                // E: Kontribusi Nelayan
                $this->addValidation($sheet, 'E2:E' . $rowCount, $kontribusiNelayanOptions);
                
                // F: Jumlah Sumber
                $this->addValidation($sheet, 'F2:F' . $rowCount, $jumlahSumberOptions);

                // G: Ketergantungan
                $this->addValidation($sheet, 'G2:G' . $rowCount, $ketergantunganOptions);

                // H: Stabilitas
                $this->addValidation($sheet, 'H2:H' . $rowCount, $stabilitasOptions);

                // I: Keterlibatan Perempuan
                $this->addValidation($sheet, 'I2:I' . $rowCount, $keterlibatanOptions);

                // J: Kontribusi Perempuan
                $this->addValidation($sheet, 'J2:J' . $rowCount, $kontribusiPrOptions);
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
