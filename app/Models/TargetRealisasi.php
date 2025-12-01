<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetRealisasi extends Model
{
    use HasFactory;

    protected $table = 'target_realisasi';

    protected $fillable = [
        'nama_knmp',
        'ppk',
        'kontraktor',
        'target_fisik',
        'realisasi_fisik',
    ];
}
