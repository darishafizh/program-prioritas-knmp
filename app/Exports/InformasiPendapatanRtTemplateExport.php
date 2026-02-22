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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

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
            // Default placeholder rows - formula di kolom D (index 4, kolom ke-4)
            return [
                ['Nama Responden 1', '', '', '=B2+C2', '', '', '', '', '', ''],
                ['Nama Responden 2', '', '', '=B3+C3', '', '', '', '', '', ''],
            ];
        }

        $respondents = InformasiResponden::whereIn('id', $this->respondenIds)
            ->orderBy('id')
            ->get(['id', 'nama_responden']);

        // Offset baris: baris 2 = data pertama (baris 1 = header)
        $startRow = 2;
        return $respondents->values()->map(function ($responden, $index) use ($startRow) {
            $row = $startRow + $index;
            return [
                $responden->nama_responden,
                '', // B: pendapatan_perikanan
                '', // C: pendapatan_non_perikanan
                '=B' . $row . '+C' . $row, // D: pendapatan_total (formula)
                '', // E: kontribusi_nelayan_persen
                '', // F: jumlah_sumber_penghasilan
                '', // G: ketergantungan_perikanan
                '', // H: stabilitas_pendapatan
                '', // I: keterlibatan_perempuan
                '', // J: kontribusi_perempuan_persen
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'nama_responden',           // A
            'pendapatan_perikanan',     // B
            'pendapatan_non_perikanan', // C
            'pendapatan_total',         // D (formula)
            'kontribusi_nelayan_persen',// E
            'jumlah_sumber_penghasilan',// F
            'ketergantungan_perikanan', // G
            'stabilitas_pendapatan',    // H
            'keterlibatan_perempuan',   // I
            'kontribusi_perempuan_persen', // J
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $sheet->getHighestRow();

        // Format kolom B, C, D sebagai angka (rupiah)
        $numberFormat = '#,##0';
        $sheet->getStyle('B2:D' . max($rowCount, 1000))
            ->getNumberFormat()
            ->setFormatCode($numberFormat);

        // Kunci kolom D agar tidak bisa diedit (protected / locked)
        // Cukup beri warna beda agar user tahu ini formula otomatis
        $sheet->getStyle('D1:D' . max($rowCount, 1000))
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E8F5E9'); // hijau muda = otomatis

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
     * Register events to add data validation (dropdowns) and number format
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $rowCount = 1000;

                // Dropdown options
                $kontribusiNelayanOptions = '"Kurang dari 50%,50-80%,Lebih dari 80%,100% (satu-satunya sumber pendapatan)"';
                $jumlahSumberOptions      = '"1 (hanya satu sumber) dari nelayan,2 sumber,3 sumber,Lebih dari 3 sumber"';
                $ketergantunganOptions    = '"Sangat bergantung,Cukup bergantung,Sedikit bergantung,Tidak bergantung"';
                $stabilitasOptions        = '"Stabil sepanjang tahun,Cenderung stabil,Tidak stabil,Sangat tidak stabil"';
                $keterlibatanOptions      = '"Selalu,Sering,Jarang,Tidak pernah"';
                $kontribusiPrOptions      = '"Lebih dari 75%,51%-75%,25%-50%,Kurang dari 25%,Perempuan tidak dilibatkan dalam kegiatan ekonomi rumah tangga"';

                // A: nama_responden — tidak ada dropdown
                // B: pendapatan_perikanan — input angka bebas (sudah diformat number)
                // C: pendapatan_non_perikanan — input angka bebas
                // D: pendapatan_total — formula otomatis, tidak perlu dropdown

                // E: Kontribusi Nelayan Persen
                $this->addValidation($sheet, 'E2:E' . $rowCount, $kontribusiNelayanOptions);

                // F: Jumlah Sumber Penghasilan
                $this->addValidation($sheet, 'F2:F' . $rowCount, $jumlahSumberOptions);

                // G: Ketergantungan Perikanan
                $this->addValidation($sheet, 'G2:G' . $rowCount, $ketergantunganOptions);

                // H: Stabilitas Pendapatan
                $this->addValidation($sheet, 'H2:H' . $rowCount, $stabilitasOptions);

                // I: Keterlibatan Perempuan
                $this->addValidation($sheet, 'I2:I' . $rowCount, $keterlibatanOptions);

                // J: Kontribusi Perempuan Persen
                $this->addValidation($sheet, 'J2:J' . $rowCount, $kontribusiPrOptions);

                // Tambah komen di header D supaya user tahu ini otomatis
                $sheet->getComment('D1')->getText()->createTextRun('Kolom ini terisi otomatis (= pendapatan_perikanan + pendapatan_non_perikanan). Jangan diubah.');
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
