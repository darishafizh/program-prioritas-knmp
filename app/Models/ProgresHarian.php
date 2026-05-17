<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresHarian extends Model
{
    protected $table = 'progres_harian';

    protected $fillable = [
        'knmp_konstruksi_id',
        'progres',
        'keterangan',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'progres' => 'decimal:2',
    ];

    public function konstruksiKnmp()
    {
        return $this->belongsTo(KonstruksiKnmp::class, 'knmp_konstruksi_id');
    }

}
