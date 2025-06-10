<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel;
use App\Models\CategoryModel;
use App\Models\ProfesiModel;
use App\Models\TracerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Fluent;

class TracerController extends Controller
{
    public function index()
{
    $data = TracerModel::where('alumni_id', auth()->id())->first();
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
        // Cek apakah user sudah pernah submit
        $exists = TracerModel::where('alumni_id', auth()->id())->exists();
        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Data sudah pernah dikirim. Anda hanya dapat mengedit.'
            ], 403);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'tanggal_pertama_kerja' => 'required|date',
            'tanggal_mulai_instansi' => 'required|date',
            'jenis_instansi' => 'required|string|max:100',
            'nama_instansi' => 'required|string|max:150',
            'skala' => 'required|string|max:100',
            'lokasi_instansi' => 'required|string|max:150',
            'kategori_profesi' => 'required|string|max:100',
            'profesi_id' => 'nullable|exists:profesi,id_profesi',
            'nama_atasan_langsung' => 'required|string|max:100',
            'jabatan_atasan_langsung' => 'required|string|max:100',
            'no_hp_atasan' => 'required|string|max:20',
            'email_atasan' => 'required|email|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['alumni_id'] = auth()->id();

        $tracer = TracerModel::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $tracer
        ]);
    }

    public function edit_ajax($id)
    {
        $data = TracerModel::findOrFail($id);
        return view('alumni.tracer.edit_ajax', compact('data'));
    }

    public function update_ajax(Request $request, $id)
    {
        $tracer = TracerModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tanggal_pertama_kerja' => 'required|date',
            'tanggal_mulai_instansi' => 'required|date',
            'jenis_instansi' => 'required|string|max:100',
            'nama_instansi' => 'required|string|max:150',
            'skala' => 'required|string|max:100',
            'lokasi_instansi' => 'required|string|max:150',
            'kategori_profesi' => 'required|string|max:100',
            'profesi_id' => 'nullable|exists:profesi,id_profesi',
            'nama_atasan_langsung' => 'required|string|max:100',
            'jabatan_atasan_langsung' => 'required|string|max:100',
            'no_hp_atasan' => 'required|string|max:20',
            'email_atasan' => 'required|email|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $tracer->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui'
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
