<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeteranganEnumerator extends Model
{
    use HasFactory;

    protected $table = 'keterangan_enumerator';

    protected $fillable = [
        'nama_enumerator',
        'tanggal_wawancara',
        'tanggal_editing',
        'nama_pemvalidasi',
    ];
}
