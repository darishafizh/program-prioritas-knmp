<?php

namespace App\Imports;

use App\Models\SosialKelembagaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SosialKelembagaanImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $knmpId;

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
    }

    public function model(array $row)
    {
        return new SosialKelembagaan([
            'knmp_id' => $this->knmpId,
            'responden_id' => $row['responden_id'] ?? null,
            'anggota_kelompok' => $row['anggota_kelompok'] ?? null,
            'manfaat_kelompok' => $row['manfaat_kelompok'] ?? null,
            'anggota_koperasi' => $row['anggota_koperasi'] ?? null,
            'tertarik_koperasi' => $row['tertarik_koperasi'] ?? null,
            'manfaat_koperasi' => $row['manfaat_koperasi'] ?? null,
            'koperasi_rapat_tahunan' => $row['koperasi_rapat_tahunan'] ?? null,
            'koperasi_partisipasi_aktif' => $row['koperasi_partisipasi_aktif'] ?? null,
            'koperasi_pengurus_kompeten' => $row['koperasi_pengurus_kompeten'] ?? null,
            'koperasi_transparan' => $row['koperasi_transparan'] ?? null,
            'koperasi_keuangan_sehat' => $row['koperasi_keuangan_sehat'] ?? null,
            'koperasi_jaringan_pasar' => $row['koperasi_jaringan_pasar'] ?? null,
            'koperasi_kepercayaan_usaha' => $row['koperasi_kepercayaan_usaha'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'responden_id' => 'required|exists:informasi_responden,id',
        ];
    }
}
