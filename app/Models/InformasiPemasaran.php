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
        'kendala_pemasaran_text',
        'cara_penanganan_ikan',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }

    public function detailPenjualan()
    {
        return $this->hasOne(DetailPenjualanIkan::class, 'pemasaran_id');
    }
}
