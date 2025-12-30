<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnmpProvinces extends Model
{
    use HasFactory;
    protected $table = 'knmp_provinces';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
}
