<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TingkatKebahagiaanNelayan extends Model
{
    use HasFactory;

    protected $table = 'tingkat_kebahagiaan_nelayan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'knmp_id',
        'nomor_soal',
        'kategori',
        'jawaban_teks',
        'skor_nilai',
    ];

    public function profile_knmp()
    {
        return $this->belongsTo(ProfileKnmp::class, 'knmp_id');
    }
}
