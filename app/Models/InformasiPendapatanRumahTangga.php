<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPendapatanRumahTangga extends Model
{
    use HasFactory;
    protected $table = 'informasi_pendapatan_rumah_tangga';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_id',
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

    // Relasi ke knmp
    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
