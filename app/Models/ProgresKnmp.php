<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresKnmp extends Model
{
    protected $table = 'progres_knmp';

    protected $fillable = [
        'knmp_id',
        'anggaran_total',
        'anggaran_konstruksi',
        'anggaran_sarpras',
        'tk_total',
        'tk_laki',
        'tk_perempuan',
        'tk_upah',
        'tk_durasi',
        'tk_lokal',
        'tk_luar',
        'tk_non_konstruksi_jumlah',
        'tk_non_konstruksi_ket',
        'kendala',
        'cctv',
    ];

    protected $casts = [
        // Remove array cast for kendala and cctv - they should be strings
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }

    public function details()
    {
        return $this->hasMany(ProgresKnmpDetail::class, 'progres_id');
    }
}
