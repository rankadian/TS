<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Fluent;

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
        return view('alumni.dashboard.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $alumni = AlumniModel::select('id', 'program_study', 'year_graduated', 'name', 'no_hp', 'email', 'nim');

        return DataTables::of($alumni)
            ->addIndexColumn()
            ->editColumn('year_graduated', function ($alumni) {
                try {
                    return Carbon::createFromFormat('Y-m-d', $alumni->year_graduated)->format('d/m/Y');
                } catch (\Exception $e) {
                    return $alumni->year_graduated;
                }
            })
            ->addColumn('aksi', function ($a) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/data-alumni/' . $a->id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/data-alumni/' . $a->id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button>';
                return $btn; // ✅ Tambahkan return
            })
            ->rawColumns(['aksi'])
            ->order(function ($query) use ($request) {
                if ($request->order) {
                    $columns = ['id', 'program_study', 'year_graduated', 'name', 'no_hp', 'email', 'nim'];
                    $orderColumn = $columns[$request->order[0]['column']] ?? 'id';
                    $orderDir = $request->order[0]['dir'] ?? 'asc';
                    $query->orderBy($orderColumn, $orderDir);
                }
            })
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

    public function dashboard_welcome()
    {
        return view('alumni.dashboard.welcome', [
            'activeMenu' => 'dashboard',
            'breadcrumb' => new Fluent([
                'title' => 'Dashboard',
                'list' => ['Home', 'Dashboard'],
            ]),
        ]);
    }
}
