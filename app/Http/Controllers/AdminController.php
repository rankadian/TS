<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\AlumniModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Welcome to Admin Dashboard',
            'list' => ['Home', 'Welcome']
        ];

        $page = (object)[
            'title' => 'List of admins registered in the system'
        ];

        $activeMenu = 'admin';
        $admin = AdminModel::all();
        return view('admin.dashboard.index', ['breadcrumb' => $breadcrumb, 'admin' => $admin, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $admins = AdminModel::select('admin_id', 'name', 'email');

        if ($request->filled('level_id')) {
            $admins->where('level_id', $request->level_id);
        }

        return DataTables::of($admins)
            ->addIndexColumn()
            ->addColumn('aksi', function ($admin) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/' . $admin->admin_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/' . $admin->admin_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/' . $admin->admin_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.dashboard.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:m_admin,email',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'msgField' => $validator->errors()
            ]);
        }

        AdminModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Admin created successfully'
        ]);
    }

    public function show_ajax(String $id)
    {
        $admin = AdminModel::find($id);
        $role = RoleModel::select('role_id', 'role_name')->get();

        return view('admin.dashboard.show_ajax', compact('admin', 'role'));
    }

    public function edit_ajax(string $id)
    {

        $admin = AdminModel::find($id);
        $role = RoleModel::select('role_id', 'role_name')->get();

        return view('admin.dashboard.edit_ajax', ['admin' => $admin, 'role' => $role]);
    }

    public function update_ajax(Request $request, $id)
    {
        $admin = AdminModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:m_admin,email,' . $id . ',admin_id',
            'password' => 'nullable|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'msgField' => $validator->errors()
            ]);
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        if (!empty($request->password)) {
            $admin->password = Hash::make($request->password);
        }
        $admin->role_id = $request->role_id;
        $admin->save();

        return response()->json([
            'status' => true,
            'message' => 'Admin updated successfully'
        ]);
    }


    public function confirm_ajax(string $id)
    {
        $admin = AdminModel::find($id);;

        return view('admin.dashboard.confirm_ajax', ['admin' => $admin]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $admin = AdminModel::find($id);
            if ($admin) {
                $admin->delete();
                return response()->json([
                    'status'    => true,
                    'message'   => 'Data successfully deleted'
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data not found'
                ]);
            }
        }
        return redirect('/');
    }

    public function import()
    {
        return view('admin.dashboard.import');
    }

    public function import_ajax(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'file_alumni' => ['required', 'mimes:xlsx', 'max:1024']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $file = $request->file('file_alumni');

            if (!$file->isValid()) {
                throw new \Exception('Uploaded file is not valid');
            }

            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getPathname());

            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            if (count($data) <= 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport (file kosong atau hanya header)'
                ]);
            }

            $insert = [];
            foreach ($data as $baris => $value) {
                if ($baris > 1 && !empty($value['B'])) {
                    $insert[] = [
                        'alumni_id' => $value['A'],
                        'program_study' => $value['B'],
                        'nim' => $value['C'],
                        'name' => $value['D'],
                        'email' => $value['E'],
                        'year_graduated' => $value['F'],
                        'created_at' => now(),
                    ];
                }
            }

            if (!empty($insert)) {
                AlumniModel::insertOrIgnore($insert);
                return response()->json([
                    'status' => true,
                    'message' => 'Data imported successfully',
                    'count' => count($insert)
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'No valid data found'
            ]);
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'File reading error: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
