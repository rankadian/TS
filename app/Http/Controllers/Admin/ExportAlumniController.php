<?php

namespace App\Http\Controllers\Admin;

use App\Models\AlumniModel;
use App\Models\SurveyModel;
use App\Models\TracerModel;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportAlumniController extends Controller
{
    public function exportPdf()
    {
        // Data Statistik Alumni
        $totalAlumni = AlumniModel::count();

        // Data Tracer Study
        $filledTracer = TracerModel::distinct('alumni_id')->count('alumni_id');
        $notFilledTracer = $totalAlumni - $filledTracer;

        // Data Survey
        $filledSurvey = SurveyModel::distinct('alumni_id')->count('alumni_id');
        $notFilledSurvey = $totalAlumni - $filledSurvey;

        // Kategori Pekerjaan
        $infokomCount = TracerModel::where('category_profession', 'infokom')->count();
        $nonInfokomCount = TracerModel::where('category_profession', '!=', 'infokom')->count();

        // Distribusi Profesi (join dengan tabel profesi)
        $professionDistribution = TracerModel::join('profesi', 'tracer.profesi_id', '=', 'profesi.id_profesi')
            ->select('profesi.nama_profesi as profession')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('profesi.nama_profesi')
            ->orderBy('count', 'desc')
            ->get();

        // Ambil semua rata-rata dari kolom-kolom kompetensi
        $scores = SurveyModel::selectRaw('
            AVG(teamwork) as teamwork,
            AVG(it_skills) as it_skills,
            AVG(foreign_language) as foreign_language,
            AVG(communication) as communication,
            AVG(self_development) as self_development,
            AVG(leadership) as leadership,
            AVG(work_ethic) as work_ethic
        ')->first();

        // Rata-rata skor (kelompokkan secara tematik)
        $averageScores = [
            'satisfaction' => round(($scores->communication + $scores->teamwork + $scores->work_ethic) / 3, 2),
            'relevance'    => round(($scores->it_skills + $scores->foreign_language) / 2, 2),
            'competence'   => round(($scores->leadership + $scores->self_development) / 2, 2),
        ];

        // Data dikirim ke view PDF
        $data = [
            'totalAlumni'            => $totalAlumni,
            'filledTracer'           => $filledTracer,
            'notFilledTracer'        => $notFilledTracer,
            'filledSurvey'           => $filledSurvey,
            'notFilledSurvey'        => $notFilledSurvey,
            'infokomCount'           => $infokomCount,
            'nonInfokomCount'        => $nonInfokomCount,
            'professionDistribution' => $professionDistribution,
            'averageScores'          => $averageScores,
            'tanggal'                => now()->format('d F Y'),
        ];

        // Render PDF
        $pdf = PDF::loadView('admin.dashboard.ekspor', $data);
        return $pdf->download('laporan_data_alumni_' . now()->format('Ymd') . '.pdf');
    }
}
