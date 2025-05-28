<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
        return $this->hasMany(Alumni::class, 'role_id', 'role_id');
    }
}
