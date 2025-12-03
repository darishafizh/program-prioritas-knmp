<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiUsaha extends Model
{
    protected $table = 'informasi_usaha';

    protected $fillable = [
        'nama_usaha',
        'jenis_usaha',
        'alamat',
        'tahun_berdiri'
    ];
}
