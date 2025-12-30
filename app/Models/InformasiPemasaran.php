<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPemasaran extends Model
{
    use HasFactory;

    protected $table = 'informasi_pemasaran';
    protected $primaryKey = 'id';

    protected $fillable = [
        'knmp_id',
        'responden_id',
        'kendala_pemasaran_text',
        'cara_penanganan_ikan',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }

    public function detail_pemasaran()
    {
        return $this->hasOne(DetailPemasaranIkan::class, 'pemasaran_id');
    }
    public function responden()
    {
        return $this->belongsTo(InformasiResponden::class, 'responden_id');
    }
}
