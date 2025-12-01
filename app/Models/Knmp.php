<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Knmp extends Model
{
    use HasFactory;
    protected $table = 'knmp';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'desa_id',
        'kecamatan_id',
        'kabupaten_id',
        'provinsi_id',
    ];
}
