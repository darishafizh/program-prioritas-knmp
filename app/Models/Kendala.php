<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendala extends Model
{
    use HasFactory;

    protected $table = 'kendala_knmp';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_id',
        'kendala',
    ];

    public function profile_knmp()
    {
        return $this->belongsTo(ProfileKnmp::class, 'knmp_id');
    }
}
