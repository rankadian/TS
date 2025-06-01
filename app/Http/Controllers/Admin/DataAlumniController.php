<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class DataAlumniController extends Controller
{
    // DataAlumniController.php
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Alumni',
            'list' => ['Home', 'Data Alumni']
        ];

        $page = (object)[
            'title' => 'List of registered alumni'
        ];

        $activeMenu = 'data-alumni';

        return view('admin.dataalumni.index', compact('breadcrumb', 'page', 'activeMenu'));
    }


    public function list(Request $request)
    {
        $alumni = AlumniModel::select('id', 'program_study', 'year_graduated', 'name', 'no_hp', 'email', 'nim');

        return DataTables::of($alumni)
            ->addIndexColumn()
            ->addColumn('aksi', function ($a) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/data/alumni/' . $a->id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/data/alumni/' . $a->id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/data/alumni/' . $a->id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->order(function ($query) use ($request) {
                if ($request->order) {
                    // Urutan kolom sesuai DataTable (index, prodi, tahun lulus, name, no_hp, email, nim)
                    $columns = ['id', 'program_study', 'tahun_lulus', 'name', 'no_hp', 'email', 'nim'];
                    $orderColumn = $columns[$request->order[0]['column']];
                    $orderDir = $request->order[0]['dir'];
                    $query->orderBy($orderColumn, $orderDir);
                }
            })
            ->make(true);
    }



    public function create_ajax()
    {
        $roles = RoleModel::all();
        return view('admin.dataalumni.create_ajax', compact('roles'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:m_alumni,email',
            'nim' => 'required|unique:m_alumni,nim',
            'tahun_lulus' => 'required|integer',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        AlumniModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'tahun_lulus' => $request->tahun_lulus,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Alumni berhasil ditambahkan'
        ]);
    }

    public function show_ajax($id)
    {
        $alumni = AlumniModel::find($id);
        $roles = RoleModel::all();

        return view('admin.dataalumni.show_ajax', compact('alumni', 'roles'));
    }

    public function edit_ajax($id)
    {
        $alumni = AlumniModel::find($id);
        $roles = RoleModel::all();

        return view('admin.dataalumni.edit_ajax', compact('alumni', 'roles'));
    }

    public function update_ajax(Request $request, $id)
    {
        $alumni = AlumniModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:m_alumni,email,' . $id,
            'nim' => 'required|unique:m_alumni,nim,' . $id,
            'tahun_lulus' => 'required|integer',
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
            'tahun_lulus' => $request->tahun_lulus,
            'role_id' => $request->role_id,
            'password' => $request->password ? Hash::make($request->password) : $alumni->password
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data alumni berhasil diperbarui'
        ]);
    }

    public function confirm_ajax($id)
    {
        $alumni = AlumniModel::find($id);
        return view('admin.dataalumni.confirm_ajax', compact('alumni'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $alumni = AlumniModel::find($id);
            if ($alumni) {
                $alumni->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data alumni berhasil dihapus'
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Data alumni tidak ditemukan'
            ]);
        }
        return redirect('/');
    }
}
