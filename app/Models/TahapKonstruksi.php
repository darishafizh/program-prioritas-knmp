<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahapKonstruksi extends Model
{
    protected $table = 'tahap_konstruksi';

    protected $fillable = [
        'knmp_konstruksi_id',
        'periode_mingguan',
        'bobot_rencana_kumulatif',
        'bobot_realisasi_kumulatif',
    ];

    protected $casts = [
        'periode_mingguan'          => 'integer',
        'bobot_rencana_kumulatif'   => 'decimal:2',
        'bobot_realisasi_kumulatif' => 'decimal:2',
    ];

    public function konstruksi()
    {
        return $this->belongsTo(KonstruksiKnmp::class, 'knmp_konstruksi_id');
    }
}
