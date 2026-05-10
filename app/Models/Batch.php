<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batch';

    protected $fillable = ['nama_tahap', 'tahun'];

    protected $casts = [
        'tahun' => 'integer',
    ];

    public function knmp()
    {
        return $this->hasMany(Knmp::class, 'batch_id');
    }
}
