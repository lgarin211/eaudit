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
        'nama_file',
        'original_name',
        'file_path',
        'file_size',
        'file_type'
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
}
