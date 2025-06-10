<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerModel extends Model
{
    use HasFactory;

    protected $table = 'tracer';

    protected $fillable = [
        'alumni_id',
        'tanggal_pertama_kerja',
        'tanggal_mulai_instansi',
        'jenis_instansi',
        'nama_instansi',
        'skala',
        'lokasi_instansi',
        'kategori_profesi',
        'profesi_id',
        'nama_atasan_langsung',
        'jabatan_atasan_langsung',
        'no_hp_atasan',
        'email_atasan',
    ];

    // Relasi ke tabel alumni
    public function alumni()
    {
        return $this->belongsTo(AlumniModel::class, 'alumni_id', 'id');
    }

    // Relasi ke tabel profesi
    public function profesi()
    {
        return $this->belongsTo(ProfesiModel::class, 'profesi_id', 'id_profesi');
    }
}
