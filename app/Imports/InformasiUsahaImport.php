<?php

namespace App\Imports;

use App\Models\InformasiUsaha;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class InformasiUsahaImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $knmpId;

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
    }

    public function model(array $row)
    {
        return new InformasiUsaha([
            'knmp_id' => $this->knmpId,
            'responden_id' => $row['responden_id'] ?? null,
            'nama_kapal' => $row['nama_kapal'] ?? null,
            'tahun_pembuatan' => $row['tahun_pembuatan'] ?? null,
            'ukuran_gt' => $row['ukuran_gt'] ?? null,
            'dimensi_perahu' => $row['dimensi_perahu'] ?? null,
            'jenis_bahan_baku' => $row['jenis_bahan_baku'] ?? null,
            'jenis_mesin' => $row['jenis_mesin'] ?? null,
            'alat_penyimpanan' => $row['alat_penyimpanan'] ?? null,
            'jenis_alat_tangkap' => $row['jenis_alat_tangkap'] ?? null,
            'hari_per_trip' => $row['hari_per_trip'] ?? null,
            'waktu_melaut_jam' => $row['waktu_melaut_jam'] ?? null,
            'jarak_penangkapan_mil' => $row['jarak_penangkapan_mil'] ?? null,
            'waktu_tempuh_jam' => $row['waktu_tempuh_jam'] ?? null,
            'jml_trip_per_bulan' => $row['jml_trip_per_bulan'] ?? null,
            'jml_bulan_melaut' => $row['jml_bulan_melaut'] ?? null,
            'produksi_kg_per_trip' => $row['produksi_kg_per_trip'] ?? null,
            'penjualan_rp_per_trip' => $row['penjualan_rp_per_trip'] ?? null,
            'biaya_solar_rp' => $row['biaya_solar_rp'] ?? null,
            'volume_solar_liter' => $row['volume_solar_liter'] ?? null,
            'biaya_bensin_rp' => $row['biaya_bensin_rp'] ?? null,
            'volume_bensin_liter' => $row['volume_bensin_liter'] ?? null,
            'biaya_es_balok_rp' => $row['biaya_es_balok_rp'] ?? null,
            'volume_es_balok' => $row['volume_es_balok'] ?? null,
            'biaya_es_kantong_rp' => $row['biaya_es_kantong_rp'] ?? null,
            'volume_es_kantong' => $row['volume_es_kantong'] ?? null,
            'total_biaya_operasional' => $row['total_biaya_operasional'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'responden_id' => 'required|exists:informasi_responden,id',
        ];
    }
}
