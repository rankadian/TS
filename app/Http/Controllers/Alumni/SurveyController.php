<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel;
use App\Models\TracerModel;
use App\Models\SurveyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    public function index()
    {
        $tracer = TracerModel::with('alumni')->where('alumni_id', auth()->id())->first();
        $survey = SurveyModel::where('alumni_id', auth()->id())->first();
        $alumniList = AlumniModel::select('nim', 'name', 'program_study', 'year_graduated', 'email')->get();

        $breadcrumb = (object)[
            'title' => 'Alumni Satisfaction Survey',
            'list' => ['Home', 'Survey']
        ];

        return view('alumni.survey.index', [
            'activeMenu' => 'survey',
            'tracer' => $tracer,
            'survey' => $survey,
            'alumniList' => $alumniList,
            'isSubmitted' => !is_null($survey),
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function store_ajax(Request $request)
    {
        $exists = SurveyModel::where('alumni_id', auth()->id())->exists();
        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'The survey has already been submitted. You can only edit.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nim' => 'required|exists:m_alumni,nim',
            'teamwork' => 'required|integer|between:1,4',
            'it_skills' => 'required|integer|between:1,4',
            'foreign_language' => 'required|integer|between:1,4',
            'communication' => 'required|integer|between:1,4',
            'self_development' => 'required|integer|between:1,4',
            'leadership' => 'required|integer|between:1,4',
            'work_ethic' => 'required|integer|between:1,4',
            'unmet_competencies' => 'nullable|string',
            'curriculum_suggestions' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $alumni = AlumniModel::where('nim', $request->nim)->first();

        $data = $request->only([
            'teamwork',
            'it_skills',
            'foreign_language',
            'communication',
            'self_development',
            'leadership',
            'work_ethic',
            'unmet_competencies',
            'curriculum_suggestions'
        ]);

        $data['alumni_id'] = $alumni->id;

        $survey = SurveyModel::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Survey submitted successfully',
            'data' => $survey
        ]);
    }

    public function edit_ajax($id)
    {
        $survey = SurveyModel::findOrFail($id);
        $alumniList = AlumniModel::all();

        return view('alumni.survey.edit_ajax', compact('survey', 'alumniList'));
    }

    public function update_ajax(Request $request, $id)
    {
        $validated = $request->validate([
        'nim' => 'required|exists:alumni,nim',
        'teamwork' => 'required|integer|between:1,4',
        'it_skills' => 'required|integer|between:1,4',
        'foreign_language' => 'required|integer|between:1,4',
        'communication' => 'required|integer|between:1,4',
        'self_development' => 'required|integer|between:1,4',
        'leadership' => 'required|integer|between:1,4',
        'work_ethic' => 'required|integer|between:1,4',
        'unmet_competencies' => 'nullable|string',
        'curriculum_suggestions' => 'nullable|string',
    ]);

    $survey = SurveyModel::findOrFail($id);
    
    // Update data
    $survey->update([
        'alumni_id' => AlumniModel::where('nim', $validated['nim'])->first()->id,
        'teamwork' => $validated['teamwork'],
        'it_skills' => $validated['it_skills'],
        'foreign_language' => $validated['foreign_language'],
        'communication' => $validated['communication'],
        'self_development' => $validated['self_development'],
        'leadership' => $validated['leadership'],
        'work_ethic' => $validated['work_ethic'],
        'unmet_competencies' => $validated['unmet_competencies'],
        'curriculum_suggestions' => $validated['curriculum_suggestions'],
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Survey data updated successfully'
    ]);
}
    public function show_ajax($id)
    {
        $survey = SurveyModel::with(['alumni', 'tracer'])->findOrFail($id);
        return response()->json([
            'status' => true,
            'data' => $survey
        ]);
    }
    
}
