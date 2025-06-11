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
    'date_first_work',
    'agency_start_date',
    'type_agency',
    'agency_name',
    'scale',
    'location_agency',
    'category_profession',
    'profesi_id',
    'name_direct_superior',
    'position_direct_superior',
    'no_hp_superior',
    'email_superior'
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
