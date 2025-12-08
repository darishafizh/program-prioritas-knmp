<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresKnmpDetail extends Model
{
    use HasFactory;
    protected $table = 'progres_knmp_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'progres_id',
        'kode',
        'komponen',
        'target',
        'persen',
        'keterangan',
    ];

    public function progres()
    {
        return $this->belongsTo(ProgresKnmp::class, 'progres_id');
    }
}
