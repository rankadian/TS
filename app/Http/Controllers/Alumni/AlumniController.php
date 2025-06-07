<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AlumniController extends Controller
{
    public function index()
    {

        $breadcrumb = (object) [
            'title' => 'Welcome to Tracer Study POLINEMA',
            'list' => ['Home', 'Welcome']
        ];

        $page = (object) [
            'title' => 'List of alumni registered in the system'
        ];

        $activeMenu = 'alumni';
        $alumni = AlumniModel::all();
        return view('alumni.dashboard.index', ['breadcrumb' => $breadcrumb, 'alumni' => $alumni, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $alumnis = AlumniModel::select('alumni_id', 'program_study', 'year_graduated', 'name', 'no_hp', 'email');

        if ($request->filled('level_id')) {
            $alumnis->where('level_id', $request->level_id);
        }

        return DataTables::of($alumnis)
            ->addIndexColumn()
            ->addColumn('aksi', function ($alumni) {
                $btn = '<button onclick="modalAction(\'' . url('/alumni/' . $alumni->alumni_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn = '<button onclick="modalAction(\'' . url('/alumni/' . $alumni->alumni_id . '/edit_ajax') . '\')" class="btn btn-info btn-sm">Edit Data</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/alumni/' . $alumni->alumni_id . '/tracer_study') . '\')" class="btn btn-warning btn-sm">Fill Tracer</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/alumni/' . $alumni->alumni_id . '/survey') . '\')" class="btn btn-danger btn-sm">Fill Survey</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $alumni = AlumniModel::find($id);
        $role = RoleModel::select('role_id', 'role_name')->get();

        return view('alumni.dashboard.show_ajax', compact('alumni', 'role'));
    }

    public function edit_ajax(string $id)
    {

        $alumni = AlumniModel::find($id);
        $role = RoleModel::select('role_id', 'role_name')->get();

        return view('alumni.dashboard.edit_ajax', ['alumni' => $alumni, 'role' => $role]);
    }

    public function update_ajax(Request $request, $id)
    {
        $alumni = AlumniModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:m_alumni,email,' . $id,
            'nim' => 'required|unique:m_alumni,nim,' . $id,
            'year_graduated' => 'required|date',
            'program_study' => 'required|string|min:3',
            'password' => 'nullable|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $alumni->update([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'year_graduated' => $request->year_graduated,
            'program_study' => $request->program_study,
            'role_id' => $request->role_id ?? $alumni->role_id,
            'no_hp' => $request->no_hp ?? $alumni->no_hp,
            'password' => $request->password ? Hash::make($request->password) : $alumni->password
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Alumni data updated successfully'
        ]);
    }

}
