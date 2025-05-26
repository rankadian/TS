<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracer extends Model
{
    use HasFactory;

    protected $table = 'tracer';

    protected $fillable = [
        'user_id',
        'profesi_id',
        'tanggal_pertama_kerja',
        'tanggal_mulai_kerja_instansi',
        'jenis_instansi',
        'nama_instansi',
        'skala',
        'lokasi_instansi',
        'nama_atasan_langsung',
        'jabatan_atasan_langsung',
        'no_hp_atasan_langsung',
        'email_atasan_langsung',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profesi()
    {
        return $this->belongsTo(Profesi::class);
    }
}
