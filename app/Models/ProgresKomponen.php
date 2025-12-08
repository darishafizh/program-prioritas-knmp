<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresKomponen extends Model
{
    protected $table = 'progres_komponen';

    protected $fillable = [
        'progres_id',
        'komponen_id',
        'target',
        'progres',
        'keterangan'
    ];

    public function progres()
    {
        return $this->belongsTo(ProgresPembangunanKnmp::class, 'progres_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriKomponen::class, 'komponen_id');
    }
}
