<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahapSerahTerima extends Model
{
    protected $table = 'tahap_serah_terima';

    protected $fillable = ['knmp_id', 'nomor_kontrak', 'tanggal_serah', 'catatan'];

    protected $casts = [
        'tanggal_serah' => 'date',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
