<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiUmum extends Model
{
    use HasFactory;

    protected $table = 'informasi_umum';

    protected $fillable = [
        'nama_responden',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'status_responden',
        'jenis_program',
    ];
}
