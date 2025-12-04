<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SosialKelembagaan extends Model
{
    use HasFactory;
    protected $table = 'sosial_kelembagaan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_id',
        'anggota_kelompok',
        'manfaat_kelompok',
        'anggota_koperasi',
        'tertarik_koperasi',
        'manfaat_koperasi',
        'koperasi_rapat_tahunan',
        'koperasi_partisipasi_aktif',
        'koperasi_pengurus_kompeten',
        'koperasi_transparan',
        'koperasi_keuangan_sehat',
        'koperasi_jaringan_pasar',
        'koperasi_kepercayaan_usaha',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
