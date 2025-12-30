<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnmpDistricts extends Model
{
    use HasFactory;
    protected $table = 'knmp_districts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_regency_id',
        'name'
    ];
}
