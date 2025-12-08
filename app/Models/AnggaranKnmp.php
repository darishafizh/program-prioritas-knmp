<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggaranKnmp extends Model
{
    use HasFactory;

    protected $table = 'anggaran_knmp';
    protected $primaryKey = 'id';

    protected $fillable = [
        'knmp_id',
        'total_anggaran',
        'anggaran_konstruksi',
        'anggaran_pengadaan_sarpras',
    ];

    protected $casts = [
        'total_anggaran' => 'integer',
        'anggaran_konstruksi' => 'integer',
        'anggaran_pengadaan_sarpras' => 'integer',
    ];

    public function profile_knmp()
    {
        return $this->belongsTo(ProfilKnmp::class, 'knmp_id');
    }
}
