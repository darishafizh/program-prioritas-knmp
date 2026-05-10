<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnmpKonstruksi extends Model
{
    protected $table = 'knmp_konstruksi';

    protected $fillable = [
        'knmp_id',
        'konstruksi_id',
        'peran',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }

    public function penyedia()
    {
        return $this->belongsTo(PenyediaJasaKonstruksi::class, 'konstruksi_id');
    }
}
