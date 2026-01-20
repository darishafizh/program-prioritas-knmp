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

    /**
     * Convert text value to boolean (1 or 0)
     * Handles values like 'Ada', 'Ya', 'Yes', '1', 'true' as true
     * Others like 'Tidak', 'No', '0', 'false', null as false
     */
    private function toBoolean($value): int
    {
        if (is_null($value) || $value === '') {
            return 0;
        }
        
        $value = strtolower(trim((string) $value));
        
        $trueValues = ['ada', 'ya', 'yes', '1', 'true', 'iya', 'v', '✓', '✔'];
        
        return in_array($value, $trueValues) ? 1 : 0;
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
            // Convert infrastructure fields from text to boolean
            'infra_jalan_akses' => $this->toBoolean($row['infra_jalan_akses'] ?? null),
            'infra_listrik' => $this->toBoolean($row['infra_listrik'] ?? null),
            'infra_air_bersih' => $this->toBoolean($row['infra_air_bersih'] ?? null),
            'infra_internet' => $this->toBoolean($row['infra_internet'] ?? null),
            'infra_ipal' => $this->toBoolean($row['infra_ipal'] ?? null),
            'infra_dermaga_tambat' => $this->toBoolean($row['infra_dermaga_tambat'] ?? null),
            'infra_tpi' => $this->toBoolean($row['infra_tpi'] ?? null),
            'infra_cold_storage' => $this->toBoolean($row['infra_cold_storage'] ?? null),
            'infra_pabrik_es' => $this->toBoolean($row['infra_pabrik_es'] ?? null),
            'infra_kantor_koperasi' => $this->toBoolean($row['infra_kantor_koperasi'] ?? null),
            'infra_bengkel_nelayan' => $this->toBoolean($row['infra_bengkel_nelayan'] ?? null),
            'infra_waserda' => $this->toBoolean($row['infra_waserda'] ?? null),
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
