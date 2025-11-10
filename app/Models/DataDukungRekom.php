<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDukungRekom extends Model
{
    use HasFactory;

    protected $table = 'datadukung_rekoms';

    protected $fillable = [
        'id_jenis_temuan',
        'nama_file',
        'original_name',
        'file_size',
        'mime_type',
        'uploaded_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the jenis temuan that owns the data dukung rekom.
     */
    public function jenisTemuan()
    {
        return $this->belongsTo(\App\Models\Jenis_temuan::class, 'id_jenis_temuan');
    }

    /**
     * Get the user who uploaded the file.
     */
    public function uploader()
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }
}
