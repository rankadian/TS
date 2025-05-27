<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'program_studi_id',
        'tahun_lulus',
        'nama',
        'no_hp',
        'email',
        'role_id',
        'nim',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    // public function role()
    // {
    //     return $this->belongsTo(Role::class);
    // }

    public function tracer()
    {
        return $this->hasOne(Tracer::class);
    }

    public function survey()
    {
        return $this->hasOne(Survey::class);
    }
}
