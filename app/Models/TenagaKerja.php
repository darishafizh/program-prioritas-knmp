<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaKerja extends Model
{
    use HasFactory;

    protected $table = 'tenaga_kerja_knmp';
    protected $primaryKey = 'id';

    protected $fillable = [
        'knmp_id',
        'tk_total_konstruksi',
        'tk_laki_laki_konstruksi',
        'tk_perempuan_konstruksi',
        'upah_tenaga_kerja_per_hari',
        'lama_kerja_proyek_hari',
        'tk_jumlah_lokal',
        'tk_jumlah_luar',
        'tk_non_konstruksi_jumlah',
        'tk_non_konstruksi_jenis',
    ];

    // Casting untuk memastikan tipe data
    protected $casts = [
        'tk_total_konstruksi' => 'integer',
        'tk_laki_laki_konstruksi' => 'integer',
        'tk_perempuan_konstruksi' => 'integer',
        'upah_tenaga_kerja_per_hari' => 'integer',
        'lama_kerja_proyek_hari' => 'integer',
        'tk_jumlah_lokal' => 'integer',
        'tk_jumlah_luar' => 'integer',
        'tk_non_konstruksi_jumlah' => 'integer',
    ];

    public function profile_knmp()
    {
        // Relasi One-to-One
        return $this->belongsTo(ProfileKnmp::class, 'knmp_id');
    }
}
