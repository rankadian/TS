<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyModel extends Model
{
    use HasFactory;

    protected $table = 'survey'; 

    protected $fillable = [
        'alumni_id',
        'teamwork',
        'it_skills',
        'foreign_language',
        'communication',
        'self_development',
        'leadership',
        'work_ethic',
        'unmet_competencies',
        'curriculum_suggestions'
    ];

    public function alumni(){
        return $this->belongsTo(AlumniModel::class);
    }

    public function tracer(){
        return $this->hasOne(TracerModel::class, 'alumni_id');
    }

    public function profesi(){
        return $this->belongsTo(ProfesiModel::class, 'profesi_id', 'id_profesi');
    }

}