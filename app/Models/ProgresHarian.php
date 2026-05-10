<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresHarian extends Model
{
    protected $table = 'progres_harian';

    protected $fillable = ['knmp_id', 'tanggal', 'progres'];

    protected $casts = [
        'tanggal' => 'date',
        'progres' => 'decimal:2',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
