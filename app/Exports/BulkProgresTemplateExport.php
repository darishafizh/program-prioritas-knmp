<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Exports\Sheets\KnmpReferenceSheet;

class BulkProgresTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Progres Umum' => new ProgresKnmpMainBulkSheet(),
            'Detail Komponen' => new ProgresKnmpDetailBulkSheet(),
            'Referensi KNMP' => new KnmpReferenceSheet(),
        ];
    }
}

/**
 * Sheet 1: Data Utama Progres KNMP (Bulk)
 */
class ProgresKnmpMainBulkSheet implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    public function title(): string
    {
        return 'Progres Umum';
    }

    public function array(): array
    {
        // Sample row with knmp_id placeholder
        return [
            [
                '1 (Lihat Sheet Referensi)', // knmp_id
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
                'Faktor cuaca; Ketersediaan material bahan bangunan', // kendala
                'Ya',        // cctv
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'knmp_id', // New Column
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
        $sheet->getComment('A1')->getText()->createTextRun('Isi dengan ID dari Sheet "Referensi KNMP"');
        
        $sheet->setCellValue('P1', 'PETUNJUK PENGISIAN:');
        $sheet->setCellValue('P2', '- Isi data sesuai kolom');
        $sheet->setCellValue('P3', '- kendala: pisahkan dengan titik koma (;)');
        $sheet->setCellValue('P4', '- cctv: isi "Ya" atau "Tidak"');
        $sheet->setCellValue('P5', '- Hapus baris contoh sebelum import');

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '17A2B8'],
                ],
            ],
            'A1' => [ // Highlight knmp_id column header
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFC107'],
                ],
                'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
            ],
            'P1:P5' => [
                'font' => ['italic' => true, 'color' => ['rgb' => '6C757D']],
            ],
        ];
    }
}

/**
 * Sheet 2: Detail Komponen Pembangunan (Bulk)
 */
class ProgresKnmpDetailBulkSheet implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    public function title(): string
    {
        return 'Detail Komponen';
    }

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
                ],
            ],
            // ... truncated for brevity in template
        ];
        
        // Just providing one example row for template is cleaner than listing all
        // Or should I list all? Listing all implies I know the KNMP ID.
        // For Bulk Template, maybe just provide a few examples.
        
        return [
            [
                '1 (Lihat Sheet Referensi)', // knmp_id
                'A',   // kode
                'Tambatan Perahu / Dermaga',   // komponen
                '1',      // target (unit)
                '50',      // persen (%)
                'Progres baik',      // keterangan
            ],
            [
                '1', // knmp_id
                'A',   // kode
                'Shelter pendaratan ikan',   // komponen
                '1',      // target (unit)
                '0',      // persen (%)
                'Belum mulai',      // keterangan
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'knmp_id', // New Column
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
        $sheet->getComment('A1')->getText()->createTextRun('Isi dengan ID dari Sheet "Referensi KNMP". Wajib diisi untuk setiap baris!');

        $sheet->setCellValue('H1', 'PETUNJUK PENGISIAN:');
        $sheet->setCellValue('H2', '- knmp_id: WAJIB DIISI UNTUK SETIAP BARIS');
        $sheet->setCellValue('H3', '- kode: A/B/C/D (sesuai jenis komponen)');
        $sheet->setCellValue('H4', '- komponen: nama komponen');
        $sheet->setCellValue('H5', '- target: jumlah unit (angka)');
        $sheet->setCellValue('H6', '- persen: progres dalam % (0-100)');

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '28A745'],
                ],
            ],
            'A1' => [ // Highlight knmp_id column header
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFC107'],
                ],
                'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
            ],
            'H1:H6' => [
                'font' => ['italic' => true, 'color' => ['rgb' => '6C757D']],
            ],
        ];
    }
}
