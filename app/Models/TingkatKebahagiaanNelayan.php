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
        'responden_id', 
        'nomor_soal',
        'kategori',
        'jawaban_teks',
        'skor_nilai',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
    public function responden()
    {
        return $this->belongsTo(InformasiResponden::class, 'responden_id');
    }
}