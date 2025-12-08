<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresPembangunanKnmp extends Model
{
    use HasFactory;

    protected $table = 'progres_pembangunan_knmp';

    protected $fillable = [
        'knmp_id',
        'total_anggaran',
        'anggaran_konstruksi',
        'anggaran_sarpras',
        'tk_konstruksi_l',
        'tk_konstruksi_p',
        'upah_per_hari',
        'lama_bekerja',
        'tk_lokal',
        'tk_luar',
        'tk_non_konstruksi',
        'kendala',
        'cctv'
    ];

    protected $casts = [
        'kendala' => 'array'
    ];

    public function progresKomponen()
    {
        return $this->hasMany(ProgresKomponen::class, 'progres_id');
    }

    public function kendalaRel()
    {
        return $this->hasMany(ProgresKendala::class, 'progres_id');
    }
}
