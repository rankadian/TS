<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel;
use App\Models\CategoryModel;
use App\Models\ProfesiModel;
use App\Models\TracerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TracerController extends Controller
{
    public function index()
    {
        $data = TracerModel::with('alumni')->where('alumni_id', auth()->id())->first();
        $alumniList = AlumniModel::select('nim', 'name', 'program_study', 'no_hp', 'email', 'year_graduated')->get();
        $categories = CategoryModel::all();
        $professions = ProfesiModel::all();

        $breadcrumb = (object)[
            'title' => 'Tracer Alumni',
            'list' => ['Home', 'Tracer']
        ];

        return view('alumni.tracer.index', [
            'activeMenu' => 'tracer',
            'data' => $data,
            'alumniList' => $alumniList,
            'categories' => $categories,
            'professions' => $professions,
            'isSubmitted' => !is_null($data),
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function store_ajax(Request $request)
    {
        $exists = TracerModel::where('alumni_id', auth()->id())->exists();
        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'The data has already been sent. You can only edit.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'date_first_work' => 'required|date',
            'agency_start_date' => 'required|date',
            'type_agency' => 'required|string|max:100',
            'agency_name' => 'required|string|max:150',
            'scale' => 'required|string|max:100',
            'location_agency' => 'required|string|max:150',
            'category_profession' => 'required|string|max:100',
            'profesi_id' => 'nullable|exists:profesi,id_profesi',
            'name_direct_superior' => 'required|string|max:100',
            'position_direct_superior' => 'required|string|max:100',
            'no_hp_superior' => 'required|string|max:20',
            'email_superior' => 'required|email|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only([
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
            'email_superior',
        ]);

        $data['alumni_id'] = auth()->id();

        $tracer = TracerModel::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Data saved successfully',
            'data' => $tracer
        ]);
    }

    public function edit_ajax($id)
    {
        $data = TracerModel::findOrFail($id);
        $categories = CategoryModel::all();
        $professions = ProfesiModel::all();

        return view('alumni.tracer.edit_ajax', compact('data', 'categories', 'professions'));
    }


    public function update_ajax(Request $request, $id)
    {
        $tracer = TracerModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'date_first_work' => 'required|date',
            'agency_start_date' => 'required|date',
            'type_agency' => 'required|string|max:100',
            'agency_name' => 'required|string|max:150',
            'scale' => 'required|string|max:100',
            'location_agency' => 'required|string|max:150',
            'category_profession' => 'required|string|max:100',
            'profesi_id' => 'nullable|exists:profesi,id_profesi',
            'name_direct_superior' => 'required|string|max:100',
            'position_direct_superior' => 'required|string|max:100',
            'no_hp_superior' => 'required|string|max:20',
            'email_superior' => 'required|email|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only([
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
            'email_superior',
        ]);

        $tracer->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Data updated successfully'
        ]);
    }

    public function show_ajax($id)
    {
        $data = TracerModel::with('profesi')->findOrFail($id);
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
