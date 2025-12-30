<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPendapatanRumahTangga extends Model
{
    use HasFactory;

    protected $table = 'informasi_pendapatan_rumah_tangga';

    protected $fillable = [
        'knmp_id',
        'responden_id',

        'pendapatan_perikanan',
        'pendapatan_non_perikanan',
        'pendapatan_total',

        'kontribusi_nelayan_persen',
        'jumlah_sumber_penghasilan',
        'ketergantungan_perikanan',
        'stabilitas_pendapatan',
        'keterlibatan_perempuan',
        'kontribusi_perempuan_persen',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class);
    }

    public function responden()
    {
        return $this->belongsTo(InformasiResponden::class);
    }
}
