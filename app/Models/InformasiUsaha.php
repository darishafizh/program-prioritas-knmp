<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiUsaha extends Model
{

    use HasFactory;

    protected $table = 'informasi_usaha';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_id',
        'responden_id',
        'nama_kapal',
        'tahun_pembuatan',
        'ukuran_gt',
        'dimensi_perahu',
        'jenis_bahan_baku',
        'jenis_mesin',
        'alat_penyimpanan',
        'jenis_alat_tangkap',
        'hari_per_trip',
        'waktu_melaut_jam',
        'jarak_penangkapan_mil',
        'waktu_tempuh_jam',
        'jml_trip_per_bulan',
        'jml_bulan_melaut',
        'produksi_kg_per_trip',
        'penjualan_rp_per_trip',
        'biaya_solar_rp',
        'volume_solar_liter',
        'biaya_bensin_rp',
        'volume_bensin_liter',
        'biaya_es_balok_rp',
        'volume_es_balok',
        'biaya_es_kantong_rp',
        'volume_es_kantong',
        'total_biaya_operasional'
    ];

    protected $casts = [
        'produksi_kg_per_trip' => 'float',
        'penjualan_rp_per_trip' => 'integer',
        'total_biaya_operasional' => 'integer',
        'biaya_solar_rp' => 'integer',
        'biaya_bensin_rp' => 'integer',
        'biaya_es_balok_rp' => 'integer',
        'biaya_es_kantong_rp' => 'integer',
    ];


    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }

    public function ikan()
    {
        return $this->hasMany(InformasiUsahaIkan::class);
    }
    public function responden()
    {
        return $this->belongsTo(InformasiResponden::class, 'responden_id');
    }
}
