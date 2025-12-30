<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnmpRegencies extends Model
{
    use HasFactory;
    protected $table = 'knmp_regencies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_province_id',
        'name'
    ];
}
