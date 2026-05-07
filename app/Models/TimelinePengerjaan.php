<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelinePengerjaan extends Model
{
    protected $table = 'timeline_pengerjaan';

    protected $fillable = [
        'knmp_id',
        'periode_mingguan',
        'bobot_rencana_kumulatif',
        'bobot_realisasi_kumulatif',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
