<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProgresKnmpTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Progres Umum' => new ProgresKnmpMainSheet(),
            'Detail Komponen' => new ProgresKnmpDetailSheet(),
        ];
    }
}

/**
 * Sheet 1: Data Utama Progres KNMP
 */
class ProgresKnmpMainSheet implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        // Sample row for guidance
        return [
            [
                22000000000, // anggaran_total
                2000000000,  // anggaran_konstruksi
                200000000,   // anggaran_sarpras
                50,          // tk_laki
                10,          // tk_perempuan
                150000,      // tk_upah
                90,          // tk_durasi
                40,          // tk_lokal
                20,          // tk_luar
                5,           // tk_non_konstruksi_jumlah
                'Security, Admin', // tk_non_konstruksi_ket
                'Faktor cuaca; Ketersediaan material bahan bangunan', // kendala (pisahkan dengan titik koma)
                'Ya',        // cctv (Ya/Tidak)
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'anggaran_total',
            'anggaran_konstruksi',
            'anggaran_sarpras',
            'tk_laki',
            'tk_perempuan',
            'tk_upah',
            'tk_durasi',
            'tk_lokal',
            'tk_luar',
            'tk_non_konstruksi_jumlah',
            'tk_non_konstruksi_ket',
            'kendala',
            'cctv',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Add instructions
        $sheet->setCellValue('O1', 'PETUNJUK PENGISIAN:');
        $sheet->setCellValue('O2', '- Isi data sesuai kolom');
        $sheet->setCellValue('O3', '- kendala: pisahkan dengan titik koma (;)');
        $sheet->setCellValue('O4', '- cctv: isi "Ya" atau "Tidak"');
        $sheet->setCellValue('O5', '- Hapus baris contoh sebelum import');

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '17A2B8'],
                ],
            ],
            'O1:O5' => [
                'font' => ['italic' => true, 'color' => ['rgb' => '6C757D']],
            ],
        ];
    }
}

/**
 * Sheet 2: Detail Komponen Pembangunan
 */
class ProgresKnmpDetailSheet implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        // All component items from the form
        $components = [
            'A' => [
                'title' => 'Konstruksi',
                'items' => [
                    'Tambatan Perahu / Dermaga',
                    'Shelter pendaratan ikan',
                    'Bengkel/ Docking kapal nelayan',
                    'Kantor pengelola',
                    'Sentra kuliner produk perikanan',
                    'Balai Pertemuan Nelayan',
                    'Shelter perbaikan jaring',
                    'Shelter Cool Box',
                    'Bangunan Tapak Cold Storage',
                    'Miniplan pengolahan ikan',
                    'Kios perbekalan',
                    'Tempat pembuangan sampah dan IPAL',
                    'Musholla',
                    'Sarana toilet umum',
                    'Jalan di kawasan lahan pembangunan',
                    'Penerangan umum',
                    'Pagar, gapura, dan/atau landmark',
                    'Parkir',
                    'Talud / Revetment Sungai dan Laut',
                ],
            ],
            'B' => [
                'title' => 'Bantuan Kapal, Mesin dan API',
                'items' => ['Kapal penangkap ikan', 'Mesin kapal perikanan', 'Alat Penangkap Ikan'],
            ],
            'C' => [
                'title' => 'Bantuan Sarana Rantai Dingin',
                'items' => [
                    'Cold Storage',
                    'Pabrik Es Balok',
                    'Pabrik Es Slurry',
                    'Kendaraan Berpendingin',
                    'Cool Box',
                ],
            ],
            'D' => [
                'title' => 'SPBU Nelayan',
                'items' => ['SPBU Nelayan'],
            ],
        ];

        $rows = [];
        foreach ($components as $kode => $section) {
            foreach ($section['items'] as $item) {
                $rows[] = [
                    $kode,   // kode
                    $item,   // komponen
                    '',      // target (unit)
                    '',      // persen (%)
                    '',      // keterangan
                ];
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'kode',
            'komponen',
            'target',
            'persen',
            'keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Add instructions
        $sheet->setCellValue('G1', 'PETUNJUK PENGISIAN:');
        $sheet->setCellValue('G2', '- kode: A/B/C/D (jangan diubah)');
        $sheet->setCellValue('G3', '- komponen: nama komponen (jangan diubah)');
        $sheet->setCellValue('G4', '- target: jumlah unit (angka)');
        $sheet->setCellValue('G5', '- persen: progres dalam % (0-100)');
        $sheet->setCellValue('G6', '- keterangan: catatan tambahan');

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '28A745'],
                ],
            ],
            'G1:G6' => [
                'font' => ['italic' => true, 'color' => ['rgb' => '6C757D']],
            ],
        ];
    }
}
