<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnmpVillages extends Model
{
    use HasFactory;
    protected $table = 'knmp_villages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_district_id',
        'name'
    ];
}
