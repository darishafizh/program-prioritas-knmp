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
        'pendapatan_rata_rata_nelayan',
        'alokasi_anggaran_total',
        'anggaran_konstruksi',
        'anggaran_upah_kerja',
        'tenaga_kerja_laki_laki',
        'tenaga_kerja_perempuan',
        'tenaga_kerja_lokal',
        'tenaga_kerja_luar',
        'volume_produksi_ton',
        'nilai_produksi',
        'koordinat_lokasi',
    ];
}
