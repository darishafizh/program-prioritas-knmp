<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiUpload extends Model
{
    use HasFactory;
    protected $table = 'bukti_uploads';
    protected $primaryKey = 'id';
    protected $fillable = [
        'knmp_id',
        'nama_file',
        'path_file',
        'tipe_file',
        'ukuran_file',
    ];

    public function knmp()
    {
        return $this->belongsTo(Knmp::class, 'knmp_id');
    }
}
