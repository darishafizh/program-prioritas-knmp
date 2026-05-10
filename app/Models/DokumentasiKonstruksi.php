<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumentasiKonstruksi extends Model
{
    protected $table = 'dokumentasi_konstruksi';

    protected $fillable = ['knmp_id', 'tanggal', 'jenis_foto', 'file_url', 'keterangan'];

    protected $casts = ['tanggal' => 'date'];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
