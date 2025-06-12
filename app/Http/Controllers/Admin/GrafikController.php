<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel;
use App\Models\CategoryModel;
use App\Models\ProfesiModel;
use App\Models\SurveyModel;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    public function index()
    {
        // Statistik alumni
        $totalAlumni = AlumniModel::count();
        $tracerFilled = AlumniModel::has('tracer')->count();
        $tracerUnfilled = $totalAlumni - $tracerFilled;
        $surveyFilled = AlumniModel::has('survey')->count();
        $surveyUnfilled = $totalAlumni - $surveyFilled;

        // Pie chart kategori infokom vs non-infokom
        $categoryCounts = DB::table('category')
            ->join('profesi', 'category.category_id', '=', 'profesi.category_id')
            ->join('tracer', 'profesi.id_profesi', '=', 'tracer.profesi_id')
            ->join('m_alumni', 'm_alumni.id', '=', 'tracer.alumni_id')
            ->select('category.category_name', DB::raw('count(m_alumni.id) as total'))
            ->groupBy('category.category_name')
            ->get();

        // Bar chart profesi
        $professionCounts = DB::table('profesi')
            ->join('tracer', 'profesi.id_profesi', '=', 'tracer.profesi_id')
            ->join('m_alumni', 'm_alumni.id', '=', 'tracer.alumni_id')
            ->select('profesi.nama_profesi', DB::raw('count(m_alumni.id) as total'))
            ->groupBy('profesi.nama_profesi')
            ->get();

        // Rating survey jempol
        $surveyRatings = DB::table('survey')
        ->selectRaw('
            AVG(teamwork) as teamwork,
            AVG(it_skills) as it_skills,
            AVG(foreign_language) as foreign_language,
            AVG(communication) as communication
        ')
        ->first();

$ratingArray = [
    'teamwork' => $surveyRatings->teamwork ?? 0,
    'it_skills' => $surveyRatings->it_skills ?? 0,
    'foreign_language' => $surveyRatings->foreign_language ?? 0,
    'communication' => $surveyRatings->communication ?? 0,
];


        return view('admin.grafik.index', [
            'totalAlumni' => $totalAlumni,
            'tracerFilled' => $tracerFilled,
            'tracerUnfilled' => $tracerUnfilled,
            'surveyFilled' => $surveyFilled,
            'surveyUnfilled' => $surveyUnfilled,
            'categoryCounts' => $categoryCounts,
            'professionCounts' => $professionCounts,
            'surveyRatings' => $ratingArray,
            'activeMenu' => 'grafik',
            'breadcrumb' => (object)[
        'title' => 'Dashboard Grafik Alumni',
        'list' => ['Home', 'Dashboard', 'Grafik']
    ]
        ]);
    }
}