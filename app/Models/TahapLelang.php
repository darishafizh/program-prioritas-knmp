<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahapLelang extends Model
{
    protected $table = 'tahap_lelang';

    protected $fillable = ['knmp_id', 'tanggal_penetapan', 'catatan'];

    protected $casts = [
        'tanggal_penetapan' => 'date',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
