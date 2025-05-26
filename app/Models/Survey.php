<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'survey';

    protected $fillable = [
        'user_id',
        'kerjasama_tim',
        'keahlian_ti',
        'bahasa_asing',
        'komunikasi',
        'pengembangan_diri',
        'kepemimpinan',
        'etos_kerja',
        'instansi',
        'jabatan',
        'kompetensi_belum_terpenuhi',
        'saran_kurikulum',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
