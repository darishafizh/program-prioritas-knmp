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
        'kesesuaian_kebutuhan' => 'boolean',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
