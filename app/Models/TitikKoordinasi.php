<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitikKoordinasi extends Model
{
    protected $table = 'titik_koordinasi';

    protected $fillable = [
        'nama',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'latitude',
        'longitude'
    ];
}
