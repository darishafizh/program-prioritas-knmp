<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiResponden extends Model
{
    use HasFactory;

    protected $table = 'informasi_responden';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_id',
        'nama_responden',
        'nik',
        'nomor_kusuka',
        'tempat_lahir',
        'tanggal_lahir',
        'umur',
        'jenis_kelamin',
        'suku_bangsa',
        'pendidikan_terakhir',
        'wpp',
        'alamat',
        'no_hp_responden',
        'jumlah_anggota_rumah',
        'jumlah_anggota_perempuan_rumah',
        'jumlah_anggota_bekerja',
        'jumlah_anggota_perempuan_bekerja',
        'jumlah_abk',
        'pengalaman_usaha',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'tanggal_wawancara',
        'nama_enumerator',
        'jenis_kelamin_enumerator',
        'no_hp_enumerator',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }

    public function province()
    {
        return $this->belongsTo(KnmpProvinces::class, 'province_id');
    }

    public function regency()
    {
        return $this->belongsTo(KnmpRegencies::class, 'regency_id');
    }

    public function district()
    {
        return $this->belongsTo(KnmpDistricts::class, 'district_id');
    }

    public function village()
    {
        return $this->belongsTo(KnmpVillages::class, 'village_id');
    }
}
