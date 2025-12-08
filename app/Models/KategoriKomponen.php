<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKomponen extends Model
{
    protected $table = 'kategori_komponen';

    protected $fillable = [
        'nama',
        'tipe'
    ];

    public function progresKomponen()
    {
        return $this->hasMany(ProgresKomponen::class, 'komponen_id');
    }
}
