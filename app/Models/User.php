<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user data access configuration
     */
    public function userDataAccess()
    {
        return $this->hasOne('App\Models\UserDataAccess', 'user_id');
    }

    /**
     * Check if user has access to specific jenis temuan
     */
    public function hasAccessToJenisTemuan($jenisTemuanId)
    {
        $access = $this->userDataAccess;

        if (!$access || !$access->is_active) {
            return false;
        }

        if ($access->access_type === 'all') {
            return true;
        }

        if ($access->access_type === 'specific') {
            $allowedIds = json_decode($access->jenis_temuan_ids ?? '[]', true);
            return in_array($jenisTemuanId, $allowedIds);
        }

        return false;
    }

    /**
     * Get accessible jenis temuan IDs for this user
     */
    public function getAccessibleJenisTemuanIds()
    {
        $access = $this->userDataAccess;

        if (!$access || !$access->is_active) {
            return [];
        }

        if ($access->access_type === 'all') {
            return \App\Models\Jenis_temuan::pluck('id')->toArray();
        }

        if ($access->access_type === 'specific') {
            return json_decode($access->jenis_temuan_ids ?? '[]', true);
        }

        return [];
    }
}
