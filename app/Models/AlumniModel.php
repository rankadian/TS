<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Jika digunakan untuk login
use Illuminate\Notifications\Notifiable;

class AlumniModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'm_alumni';
    protected $primaryKey = 'id';

    protected $fillable = [
        'program_study',
        'year_graduated',
        'name',
        'no_hp',
        'email',
        'password',
        'role_id',
        'nim',
        'email_verified_at',
        'remember_token',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'tahun_lulus' => 'integer',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke model Role
     */
    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'role_id');
    }

    /**
     * Get the role name of the admin.
     */
    public function getRoleName(): string
    {
        return $this->role->role_name;
    }

    /**
     * Check if the admin has a specific role.
     */
    public function hasRole($role): bool
    {
        return $this->role->role_code === $role;
    }
}
