<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KendalaMaster extends Model
{
    protected $table = 'kendala_master';

    protected $fillable = [
        'nama'
    ];

    public function progresKendala()
    {
        return $this->hasMany(ProgresKendala::class, 'kendala_id');
    }
}
