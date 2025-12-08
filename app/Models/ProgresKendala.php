<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresKendala extends Model
{
    protected $table = 'progres_kendala';

    protected $fillable = [
        'progres_id',
        'kendala_id',
        'keterangan'
    ];

    public function progres()
    {
        return $this->belongsTo(ProgresPembangunanKnmp::class, 'progres_id');
    }

    public function kendala()
    {
        return $this->belongsTo(KendalaMaster::class, 'kendala_id');
    }
}
