<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresKnmpNasional extends Model
{
    use HasFactory;

    protected $table = 'progres_knmp_nasional';

    protected $fillable = [
        'knmp_id',
        'progres',
        'tanggal',
        'nama_jasa_konstruksi',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Get the knmp associated with the progres.
     */
    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
