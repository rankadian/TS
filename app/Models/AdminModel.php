<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'm_admin';
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relation to RoleModel
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
