<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahapDed extends Model
{
    protected $table = 'tahap_ded';

    protected $fillable = ['knmp_id', 'nomor_document', 'tanggal_pengesahan', 'file_url', 'catatan'];

    protected $casts = ['tanggal_pengesahan' => 'date'];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
