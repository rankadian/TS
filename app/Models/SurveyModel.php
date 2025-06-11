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
        'curriculum_suggestions',
    ];

    public function alumni()
    {
        return $this->belongsTo(AlumniModel::class, 'alumni_id');
    }
}
