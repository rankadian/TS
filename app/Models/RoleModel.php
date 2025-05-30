<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = 'm_role';
    protected $primaryKey = 'role_id';

    protected $fillable = [
        'role_code',
        'role_name',
    ];

    /**
     * Relasi ke banyak alumni
     */
    public function alumni()
    {
        return $this->hasMany(AlumniModel::class, 'role_id', 'role_id');
    }
}
