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
        'batch_id',
        'tahap_saat_ini',
        'nama',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'latitude',
        'longitude',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'nama';
    }

    // =========================================
    // Relasi Master/Referensi
    // =========================================
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    // =========================================
    // Relasi Wilayah (Legacy) - Disabled as per ERD update (columns are now strings)
    // =========================================

    // =========================================
    // Relasi Survey / Kuesioner (Legacy)
    // =========================================
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
        return $this->hasMany(ProgresHarian::class, 'knmp_id');
    }

    public function latestProgresNasional()
    {
        return $this->hasOne(ProgresHarian::class, 'knmp_id')->latestOfMany('tanggal');
    }

    // =========================================
    // Relasi Tahapan Program Prioritas
    // =========================================
    public function riwayatTahap()
    {
        return $this->hasMany(RiwayatTahap::class, 'knmp_id')->orderByDesc('created_at');
    }

    public function tahapUsulan()
    {
        return $this->hasOne(TahapUsulan::class, 'knmp_id');
    }

    public function tahapSurvey()
    {
        return $this->hasOne(TahapSurvey::class, 'knmp_id');
    }

    public function tahapDed()
    {
        return $this->hasOne(TahapDed::class, 'knmp_id');
    }

    public function tahapLelang()
    {
        return $this->hasOne(TahapLelang::class, 'knmp_id');
    }

    public function tahapSerahTerima()
    {
        return $this->hasOne(TahapSerahTerima::class, 'knmp_id');
    }

    public function konstruksiKnmp()
    {
        return $this->hasOne(KonstruksiKnmp::class, 'knmp_id');
    }

    public function dokumentasiKonstruksi()
    {
        return $this->hasMany(DokumentasiKonstruksi::class, 'knmp_id');
    }

    public function knmpKonstruksi()
    {
        return $this->hasMany(KnmpKonstruksi::class, 'knmp_id');
    }

    public function tahapKonstruksi()
    {
        return $this->hasManyThrough(TahapKonstruksi::class, KonstruksiKnmp::class, 'knmp_id', 'knmp_konstruksi_id');
    }

    public function timeline()
    {
        return $this->hasManyThrough(TahapKonstruksi::class, KonstruksiKnmp::class, 'knmp_id', 'knmp_konstruksi_id');
    }

    public function progresHarian()
    {
        return $this->hasMany(ProgresHarian::class, 'knmp_id');
    }

    public function latestTahapKonstruksi()
    {
        return $this->hasOneThrough(TahapKonstruksi::class, KonstruksiKnmp::class, 'knmp_id', 'knmp_konstruksi_id')->latestOfMany();
    }

    // =========================================
    // Accessor: label tahap
    // =========================================
    public function getTahapLabelAttribute(): string
    {
        return match ($this->tahap_saat_ini) {
            'usulan'       => 'Usulan',
            'survey'       => 'Survey',
            'ded'          => 'DED',
            'lelang'       => 'Lelang',
            'konstruksi'   => 'Konstruksi',
            'serah_terima' => 'Serah Terima',
            default        => ucfirst($this->tahap_saat_ini ?? 'Usulan'),
        };
    }
}
