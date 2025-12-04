<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilKnmp extends Model
{
    // jika nama tabel tidak plural standar, set explicit:
    protected $table = 'profil_knmp';

    protected $fillable = [
        'jumlah_penduduk_desa',
        'jumlah_nelayan',
        'pendapatan_rata_rata',
        'alokasi_konstruksi',
        'alokasi_upah',
        'tk_laki_laki',
        'tk_perempuan',
        'tk_lokal',
        'tk_luar',
        'volume_produksi',
        'nilai_produksi',
        'calon_kopdesmp',
        'nama_ketua',
        'sk_kopdeskel',
        'nomor_induk_kopdeskel',
        'jumlah_anggota_laki',
        'jumlah_anggota_perempuan',
        'koordinat_lokasi',
    ];
}
