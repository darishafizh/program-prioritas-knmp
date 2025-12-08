<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggapanMasyarakat extends Model
{
    use HasFactory;

    protected $table = 'tanggapan_masyarakat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'knmp_id',
        'kesesuaian_kebutuhan',
        'item_tidak_sesuai',
        'tingkat_kesenangan',
        'alasan_tidak_senang',
        'harapan_masyarakat',
        'masukan_saran_perbaikan',
    ];

    protected $casts = [
        'kesesuaian_kebutuhan' => 'boolean', // Memastikan kolom ini diperlakukan sebagai boolean
    ];

    public function knmp()
    {
        // Asumsi tabel utama yang dirujuk adalah ProfilKNMP atau knmp
        return $this->belongsTo(ProfilKnmp::class, 'knmp_id');
    }
}
