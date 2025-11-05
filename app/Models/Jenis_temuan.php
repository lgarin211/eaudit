<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis_temuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_penugasan',
        'id_parent',
        'id_pengawasan',
                'nama_temuan',
        'kode_temuan',
        'rekomendasi',
             'pengembalian',
        'keterangan',
        'kode_rekomendasi',
        'Rawdata'
    ];
}
