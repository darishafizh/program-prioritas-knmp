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
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'latitude',
        'longitude',
    ];

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
}
