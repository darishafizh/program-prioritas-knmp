<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatTahap extends Model
{
    protected $table = 'riwayat_tahap';

    protected $fillable = [
        'knmp_id',
        'tahap_dari',
        'tahap_ke',
        'keterangan',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
