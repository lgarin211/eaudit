<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDukung extends Model
{
    use HasFactory;

    protected $table = 'datadukung';

    protected $fillable = [
        'id_pengawasan',
        'id_jenis_temuan',
        'nama_file',
        'keterangan_file'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the pengawasan that owns the data dukung.
     */
    public function pengawasan()
    {
        return $this->belongsTo(Pengawasan::class, 'id_pengawasan');
    }

    /**
     * Get the jenis temuan that owns the data dukung.
     */
    public function jenisTemuan()
    {
        return $this->belongsTo(\App\Models\Jenis_temuan::class, 'id_jenis_temuan');
    }
}
