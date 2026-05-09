<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Knmp extends Model
{
    use HasFactory;
    protected $table = 'knmp';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'desa_kelurahan',
        'latitude',
        'longitude',
        'tahap',
        'tanggal_mulai',
    ];

    public function getRouteKeyName()
    {
        return 'nama';
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'provinsi');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'kabupaten_kota');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'kecamatan');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'desa_kelurahan');
    }

    public function buktiUploads()
    {
        return $this->hasMany(BuktiUpload::class, 'knmp_id');
    }

    public function profileKnmp()
    {
        return $this->hasOne(ProfileKnmp::class, 'knmp_id');
    }

    public function progresKnmp()
    {
        return $this->hasOne(ProgresKnmp::class, 'knmp_id');
    }

    public function informasiResponden()
    {
        return $this->hasMany(InformasiResponden::class, 'knmp_id');
    }

    public function progresNasional()
    {
        return $this->hasMany(ProgresKnmpNasional::class, 'knmp_id');
    }

    public function latestProgresNasional()
    {
        return $this->hasOne(ProgresKnmpNasional::class, 'knmp_id')->latestOfMany('tanggal');
    }

    public function timeline()
    {
        return $this->hasMany(TimelinePengerjaan::class, 'knmp_id');
    }
}
