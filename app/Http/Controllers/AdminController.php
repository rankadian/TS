<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

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
        return view('admin.index', ['breadcrumb' => $breadcrumb, 'admin' => $admin, 'page' => $page, 'activeMenu' => $activeMenu]);
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
        return view('admin.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama'     => 'required|string|min:3',
                'email' => 'required|string|max:100|unique:m_admin,email',
                'password' => 'required|min:5'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validation Failed',
                    'msgField'  => $validator->errors(),
                ]);
            }

            AdminModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Admin data saved successfully'
            ]);
        }
        redirect('/');
    }

    public function show_ajax(String $id)
    {
        $admin = AdminModel::find($id);
        $role = RoleModel::select('role_id', 'role_name')->get();

        return view('admin.show_ajax', compact('admin', 'role'));
    }

    public function edit_ajax(string $id)
    {

        $admin = AdminModel::find($id);
        $role = RoleModel::select('role_id', 'role_name')->get();

        return view('admin.edit_ajax', ['admin' => $admin, 'role' => $role]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name' => 'required | string | min:3',
                'email'      => 'required | string | max:100 | unique:m_admin, email' . $id . ',admin_id',
                'password' => 'nullable | min:5'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validation Failed',
                    'msgField'  => $validator->errors(),
                ]);
            }

            $check = AdminModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }

                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data successfully updated'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found'
                ]);
            }
        }
        redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $admin = AdminModel::find($id);;

        return view('admin.confirm_ajax', ['admin' => $admin]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek request dari ajax
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
}
