<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelinePengerjaan extends Model
{
    protected $table = 'timeline_pengerjaan';

    protected $fillable = [
        'knmp_id',
        'tanggal_mulai',
        'tanggal_selesai_rencana',
        'periode_minggu',
        'bobot_rencana_kumulatif',
        'bobot_realisasi_kumulatif',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai'            => 'date',
        'tanggal_selesai_rencana'  => 'date',
        'bobot_rencana_kumulatif'  => 'decimal:2',
        'bobot_realisasi_kumulatif'=> 'decimal:2',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
