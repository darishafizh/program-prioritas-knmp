<?php

namespace App\Imports;

use App\Models\TingkatKebahagiaanNelayan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class TingkatKebahagiaanNelayanImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $knmpId;

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
    }

    public function model(array $row)
    {
        return new TingkatKebahagiaanNelayan([
            'knmp_id' => $this->knmpId,
            'responden_id' => $row['responden_id'] ?? null,
            'nomor_soal' => $row['nomor_soal'] ?? null,
            'kategori' => $row['kategori'] ?? null,
            'jawaban_teks' => $row['jawaban_teks'] ?? null,
            'skor_nilai' => $row['skor_nilai'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'responden_id' => 'required|exists:informasi_responden,id',
            'nomor_soal' => 'required',
        ];
    }
}
