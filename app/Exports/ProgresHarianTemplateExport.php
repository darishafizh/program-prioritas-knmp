<?php

namespace App\Exports;

use App\Models\Knmp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class ProgresHarianTemplateExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected $tahap;

    public function __construct($tahap = null)
    {
        $this->tahap = $tahap;
    }

    public function collection()
    {
        $query = Knmp::query();
        
        if ($this->tahap && $this->tahap !== 'all') {
            $query->where('tahap_saat_ini', $this->tahap);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'knmp_id',
            'nama knmp',
            'tanggal_progres',
            'progres',
            'keterangan',
        ];
    }

    public function map($knmp): array
    {
        return [
            $knmp->id,
            $knmp->nama,
            '', // Kolom tanggal kosong
            '', // Kolom progres kosong
            '', // Kolom keterangan kosong
        ];
    }

    public function title(): string
    {
        return 'Template Progres Harian';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $rowCount = $sheet->getHighestRow();

                // 1. Dropdown options for 'keterangan' (Now Column E)
                $options = [
                    'Tenaga Kerja (Manpower)',
                    'Ketersediaan Material',
                    'Kesiapan Alat Berat',
                    'Kondisi Cuaca',
                    'Kondisi Geologis/Medan',
                    'Sosial-Masyarakat',
                    'Kualitas Dokumentasi Teknis',
                    'Proses Perizinan',
                    'Logistik & Rantai Pasok',
                    'Arus Kas Proyek (Cash Flow)',
                    'Lainnya'
                ];
                $validation = $sheet->getDataValidation('E2:E' . $rowCount);
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(true);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(false); // Allow multiple values (commas)
                $validation->setShowDropDown(true);
                $validation->setPromptTitle('Pilih/Input Keterangan');
                $validation->setPrompt("Pilih dari daftar atau ketik beberapa pilihan dipisahkan dengan koma.\n\nContoh: Tenaga Kerja (Manpower), Kondisi Cuaca");
                $validation->setFormula1('"' . implode(',', $options) . '"');

                // Add date validation for column C
                $dateValidation = $sheet->getDataValidation('C2:C' . $rowCount);
                $dateValidation->setType(DataValidation::TYPE_DATE);
                $dateValidation->setErrorStyle(DataValidation::STYLE_WARNING);
                $dateValidation->setAllowBlank(true);
                $dateValidation->setShowInputMessage(true);
                $dateValidation->setShowErrorMessage(true);
                $dateValidation->setPromptTitle('Format Tanggal');
                $dateValidation->setPrompt("Masukkan tanggal dengan format YYYY-MM-DD\nContoh: 2026-05-11");
                $dateValidation->setErrorTitle('Format Tidak Sesuai');
                $dateValidation->setError('Mohon masukkan tanggal yang valid.');
                $dateValidation->setFormula1('DATE(2020,1,1)');
                $dateValidation->setOperator(DataValidation::OPERATOR_GREATERTHANOREQUAL);

                // 2. Sheet Protection & Locking
                $protection = $sheet->getProtection();
                $protection->setSheet(true);
                $protection->setPassword('kkp-knmp'); 
                
                // Allow user to resize columns and rows
                $protection->setFormatColumns(false);
                $protection->setFormatRows(false);
                
                // Unlock columns C to Z for input (Tanggal, Progres, Keterangan)
                $sheet->getStyle('C1:Z' . $rowCount)->getProtection()->setLocked(
                    \PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED
                );

                // Lock ONLY Column A (knmp_id) and B (nama knmp)
                $sheet->getStyle('A1:B' . $rowCount)->getProtection()->setLocked(
                    \PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED
                );
            },
        ];
    }
}
