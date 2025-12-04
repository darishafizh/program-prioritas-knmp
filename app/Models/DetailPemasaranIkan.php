<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemasaranIkan extends Model
{
    use HasFactory;

    protected $table = 'detail_pemasaran_ikan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pemasaran_id',
        'eceran_kg',
        'koperasi_kg',
        'tengkulak_kg',
        'pengepul_kg',
        'pedagang_besar_kg',
        'lainnya_kg',
        'lainnya_keterangan',
    ];
}
