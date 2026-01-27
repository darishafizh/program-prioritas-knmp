<?php

namespace App\Exports;

use App\Models\Knmp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProgresKnmpNasionalTemplateExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return Knmp::all();
    }

    public function headings(): array
    {
        return [
            'knmp_id',
            'nama knmp',
            'progres',
        ];
    }

    public function map($knmp): array
    {
        return [
            $knmp->id,
            $knmp->nama,
            '', // Kolom progres kosong
        ];
    }

    public function title(): string
    {
        return 'Template Progres Nasional';
    }
}
