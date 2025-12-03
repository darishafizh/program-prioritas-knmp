<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKomponen extends Model
{
    use HasFactory;

    protected $table = 'detail_komponen';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_id',
        'jenis_komponen',
        'target_unit',
        'progress_persen', // Disesuaikan dengan kolom baru dari kuesioner
        'anggaran',
        'realisasi_anggaran',
        'persen_realisasi_anggaran',
        'keterangan', // Kolom Keterangan baru
    ];

    protected $casts = [
        'target_unit' => 'integer',
        'progress_persen' => 'decimal:2',
        'anggaran' => 'integer',
        'realisasi_anggaran' => 'integer',
        'persen_realisasi_anggaran' => 'decimal:2',
    ];

    public function profile_knmp()
    {
        return $this->belongsTo(ProfileKnmp::class, 'knmp_id');
    }
}
