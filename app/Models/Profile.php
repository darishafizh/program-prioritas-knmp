<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kampung',
        'lingkungan_kawasan',
        'aktivitas_usaha_nelayan',
        'sarana_prasarana',
        'status_kepemilikan_tanah',
        'nama_kopdeskel',
        'dasar_hukum_kopdeskel',
        'ketua_kopdeskel',
        'status_e_kusuka',
        'jenis_usaha_sebelum_knmp',
    ];
}
