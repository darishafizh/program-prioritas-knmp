<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyediaJasaKonstruksi extends Model
{
    protected $table = 'penyedia_jasa_konstruksi';

    protected $fillable = ['nama'];

    public function tahapKonstruksi()
    {
        return $this->hasMany(TahapKonstruksi::class, 'jasa_konstruksi_id');
    }
}
