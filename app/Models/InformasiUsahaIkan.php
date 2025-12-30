<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiUsahaIkan extends Model
{
    use HasFactory;
    protected $table = 'informasi_usaha_ikan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'informasi_usaha_id',
        'responden_id',
        'jenis',
        'kg_trip',
        'persen'
    ];

    public function usaha()
    {
        return $this->belongsTo(InformasiUsaha::class, 'informasi_usaha_id');
    }
    public function responden()
    {
        return $this->belongsTo(InformasiResponden::class, 'responden_id');
    }
}
