<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresTambahan extends Model
{
    use HasFactory;

    protected $table = 'progress_tambahan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_id',
        'cctv_terpasang',
    ];

    protected $casts = [
        'cctv_terpasang' => 'boolean',
    ];

    public function profile_knmp()
    {
        return $this->belongsTo(ProfileKnmp::class, 'knmp_id');
    }
}
