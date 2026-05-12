<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonstruksiKnmp extends Model
{
    protected $table = 'konstruksi_knmp';

    protected $fillable = [
        'knmp_id',
        'jasa_konstruksi_id',
        'tanggal_mulai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }

    public function penyediaJasa()
    {
        return $this->belongsTo(PenyediaJasaKonstruksi::class, 'jasa_konstruksi_id');
    }

    public function timeline()
    {
        return $this->hasMany(TahapKonstruksi::class, 'knmp_konstruksi_id');
    }
}
