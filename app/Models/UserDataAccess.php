<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDataAccess extends Model
{
    use HasFactory;

    protected $table = 'user_data_access';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'access_type',
        'jenis_temuan_ids',
        'is_active',
        'notes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'jenis_temuan_ids' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns this access configuration
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the accessible jenis temuan records
     */
    public function accessibleJenisTemuans()
    {
        if ($this->access_type === 'all') {
            return Jenis_temuan::all();
        }

        if ($this->access_type === 'specific' && $this->jenis_temuan_ids) {
            return Jenis_temuan::whereIn('id', $this->jenis_temuan_ids)->get();
        }

        return collect([]);
    }

    /**
     * Check if this access configuration allows access to specific jenis temuan
     */
    public function allowsAccessTo($jenisTemuanId)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->access_type === 'all') {
            return true;
        }

        if ($this->access_type === 'specific') {
            return in_array($jenisTemuanId, $this->jenis_temuan_ids ?? []);
        }

        return false;
    }
}
