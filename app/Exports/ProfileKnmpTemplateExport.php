<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfileKnmpTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'jml_penduduk_des',          // A
            'jml_nelayan',               // B
            'pendapatan_rata_rata_nelayan', // C
            'volume_produksi_ton',       // D
            'nilai_produksi',            // E
            'komoditas_utama_1',         // F
            'komoditas_utama_2',         // G
            'harga_rata_komoditas_1',    // H
            'harga_rata_komoditas_2',    // I
            'infra_jalan_akses',         // J
            'infra_listrik',             // K
            'infra_air_bersih',          // L
            'infra_internet',            // M
            'infra_ipal',               // N
            'infra_dermaga_tambat',      // O
            'infra_tpi',                // P
            'infra_cold_storage',        // Q
            'infra_pabrik_es',          // R
            'infra_kantor_koperasi',     // S
            'infra_bengkel_nelayan',     // T
            'infra_waserda',            // U
            'calon_koperasi',           // V
            'nama_ketua',               // W
            'sk_kopdeskel',             // X
            'nomor_induk_kopdeskel',     // Y
            'jumlah_anggota_laki',       // Z
            'jumlah_anggota_perempuan',  // AA
            'koordinat_lokasi',          // AB
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Beri warna berbeda pada kolom infra (J-U) agar mudah dibedakan
        $sheet->getStyle('J1:U1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('1E7E34'); // hijau tua untuk header infra

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $rowCount = 1000;

                // Opsi dropdown: hanya Ada atau Tidak Ada
                $infraOptions = '"Ada,Tidak Ada"';

                // Kolom infra: J s/d U (infra_jalan_akses s/d infra_waserda)
                $infraColumns = ['J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'];
                foreach ($infraColumns as $col) {
                    $this->addValidation($sheet, "{$col}2:{$col}{$rowCount}", $infraOptions);
                }
            },
        ];
    }

    private function addValidation($sheet, $cellRange, $formula)
    {
        $validation = $sheet->getCell(explode(':', $cellRange)[0])->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_STOP); // Stop = tidak bisa input selain pilihan
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Input Tidak Valid');
        $validation->setError('Hanya boleh memilih "Ada" atau "Tidak Ada".');
        $validation->setPromptTitle('Ketersediaan Infrastruktur');
        $validation->setPrompt('Pilih "Ada" jika infrastruktur tersedia, "Tidak Ada" jika belum.');
        $validation->setFormula1($formula);

        $sheet->setDataValidation($cellRange, $validation);
    }
}
