<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;


class DataAlumniController extends Controller
{
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
            ->editColumn('year_graduated', function ($alumni) {
                // parsing string tanggal YYYY-MM-DD dan format jadi dd/mm/yyyy
                try {
                    return Carbon::createFromFormat('Y-m-d', $alumni->year_graduated)->format('d/m/Y');
                } catch (\Exception $e) {
                    // kalau format string di DB beda atau error, tampilkan apa adanya
                    return $alumni->year_graduated;
                }
            })
            ->addColumn('aksi', function ($a) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/data-alumni/' . $a->id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/data-alumni/' . $a->id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/data-alumni/' . $a->id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
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


    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:m_alumni,email',
            'nim' => 'required|unique:m_alumni,nim',
            'year_graduated' => 'required|date',
            'program_study' => 'required|string|min:3',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'msgField' => $validator->errors()
            ]);
        }

        AlumniModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'year_graduated' => $request->year_graduated,
            'program_study' => $request->program_study,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id ?? 2,
            'no_hp' => $request->no_hp ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Alumni successfully added'
        ]);
    }

    public function show_ajax($id)
    {
        $alumni = AlumniModel::findOrFail($id);
        $roles = RoleModel::all();

        return view('admin.dataalumni.show_ajax', compact('alumni', 'roles'));
    }

    public function edit_ajax($id)
    {
        $alumni = AlumniModel::findOrFail($id);
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
            'year_graduated' => 'required|date',
            'program_study' => 'required|string|min:3',
            'password' => 'nullable|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
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

    public function confirm_ajax($id)
    {
        $alumni = AlumniModel::findOrFail($id);
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
                    'message' => 'Alumni data successfully deleted'
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Alumni data not found'
            ]);
        }
        return redirect('/');
    }

    public function import()
    {
        return view('admin.dataalumni.import');
    }

    public function import_ajax(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'file_alumni' => ['required', 'mimes:xlsx', 'max:1024']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan validasi',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $file = $request->file('file_alumni');

            if (!$file->isValid()) {
                return response()->json([
                    'status' => false,
                    'message' => 'File tidak valid',
                ]);
            }

            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getPathname());

            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            if (count($data) <= 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'File kosong atau hanya berisi header',
                ]);
            }

            $insert = [];

            foreach ($data as $baris => $value) {
                if ($baris > 1 && !empty($value['B']) && !empty($value['E'])) {
                    try {
                        $tanggalLulus = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['D'])->format('Y-m-d');
                    } catch (\Exception $e) {
                        $tanggalLulus = null;
                    }

                    $nim = trim((string) $value['B']);

                    $insert[] = [
                        'program_study' => (string) $value['A'],
                        'nim' => $nim,
                        'name' => (string) $value['C'],
                        'year_graduated' => $tanggalLulus,
                        'email' => (string) $value['E'],
                        'password' => bcrypt($nim),
                        'code_role' => 'AMI',
                        'role_id' => 2,
                        'created_at' => now(),
                    ];
                }
            }

            if (count($insert) > 0) {
                AlumniModel::insertOrIgnore($insert);

                return response()->json([
                    'status' => true,
                    'message' => 'Successfully import alumni data.',
                    'count' => count($insert)
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'No valid data can be saved.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the file: ' . $e->getMessage()
            ]);
        }
    }
}
