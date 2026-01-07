<?php

namespace App\Imports;

use App\Models\ProfileKnmp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ProfileKnmpImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $knmpId;

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
    }

    public function model(array $row)
    {
        return new ProfileKnmp([
            'knmp_id' => $this->knmpId,
            'jml_penduduk_des' => $row['jml_penduduk_des'] ?? null,
            'jml_nelayan' => $row['jml_nelayan'] ?? null,
            'pendapatan_rata_rata_nelayan' => $row['pendapatan_rata_rata_nelayan'] ?? null,
            'volume_produksi_ton' => $row['volume_produksi_ton'] ?? null,
            'nilai_produksi' => $row['nilai_produksi'] ?? null,
            'komoditas_utama_1' => $row['komoditas_utama_1'] ?? null,
            'komoditas_utama_2' => $row['komoditas_utama_2'] ?? null,
            'harga_rata_komoditas_1' => $row['harga_rata_komoditas_1'] ?? null,
            'harga_rata_komoditas_2' => $row['harga_rata_komoditas_2'] ?? null,
            'infra_jalan_akses' => $row['infra_jalan_akses'] ?? null,
            'infra_listrik' => $row['infra_listrik'] ?? null,
            'infra_air_bersih' => $row['infra_air_bersih'] ?? null,
            'infra_internet' => $row['infra_internet'] ?? null,
            'infra_ipal' => $row['infra_ipal'] ?? null,
            'infra_dermaga_tambat' => $row['infra_dermaga_tambat'] ?? null,
            'infra_tpi' => $row['infra_tpi'] ?? null,
            'infra_cold_storage' => $row['infra_cold_storage'] ?? null,
            'infra_pabrik_es' => $row['infra_pabrik_es'] ?? null,
            'infra_kantor_koperasi' => $row['infra_kantor_koperasi'] ?? null,
            'infra_bengkel_nelayan' => $row['infra_bengkel_nelayan'] ?? null,
            'infra_waserda' => $row['infra_waserda'] ?? null,
            'calon_koperasi' => $row['calon_koperasi'] ?? null,
            'nama_ketua' => $row['nama_ketua'] ?? null,
            'sk_kopdeskel' => $row['sk_kopdeskel'] ?? null,
            'nomor_induk_kopdeskel' => $row['nomor_induk_kopdeskel'] ?? null,
            'jumlah_anggota_laki' => $row['jumlah_anggota_laki'] ?? null,
            'jumlah_anggota_perempuan' => $row['jumlah_anggota_perempuan'] ?? null,
            'koordinat_lokasi' => $row['koordinat_lokasi'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'jml_nelayan' => 'nullable|numeric',
        ];
    }
}
