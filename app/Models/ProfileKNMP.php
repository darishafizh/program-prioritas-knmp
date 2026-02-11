<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileKnmp extends Model
{
    use HasFactory;
    protected $table = 'profile_knmp';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_id',
        'jml_penduduk_des',
        'jml_nelayan',
        'jumlah_kapal',
        'serapan_tenaga_kerja',
        'pendapatan_rata_rata_nelayan',
        'volume_produksi_ton',
        'nilai_produksi',

        'komoditas_utama_1',
        'komoditas_utama_2',
        'harga_rata_komoditas_1',
        'harga_rata_komoditas_2',

        'infra_jalan_akses',
        'infra_listrik',
        'infra_air_bersih',
        'infra_internet',
        'infra_ipal',
        'infra_dermaga_tambat',
        'infra_tpi',
        'infra_cold_storage',
        'infra_pabrik_es',
        'infra_kantor_koperasi',
        'infra_bengkel_nelayan',
        'infra_waserda',

        'calon_koperasi',
        'nama_ketua',
        'sk_kopdeskel',
        'nomor_induk_kopdeskel',
        'jumlah_anggota_laki',
        'jumlah_anggota_perempuan',
        'koordinat_lokasi',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
