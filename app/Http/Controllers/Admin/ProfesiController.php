<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfesiModel;
use App\Models\CategoryModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class ProfesiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Profesi',
            'list' => ['Home', 'Profesi']
        ];

        $page = (object)[
            'title' => 'List of Profesi'
        ];

        $activeMenu = 'profesi';

        return view('admin.profesi.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $profesi = ProfesiModel::with('category')->select('profesi.*');

        return DataTables::of($profesi)
            ->addIndexColumn()
            ->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->category_name : '-';
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/profesi/' . $row->id_profesi . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/profesi/' . $row->id_profesi . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/profesi/' . $row->id_profesi . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $categories = CategoryModel::all();
        return view('admin.profesi.create_ajax', compact('categories'));
    }

    public function show_ajax($id)
    {
        $profesi = ProfesiModel::with('category')->where('id_profesi', $id)->first();

        return view('admin.profesi.show_ajax', compact('profesi'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_profesi' => 'required|string|min:3|max:100',
            'category_id' => 'required|exists:category,category_id'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ]);
        }

        ProfesiModel::create([
            'nama_profesi' => $request->nama_profesi,
            'category_id' => $request->category_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data profesi berhasil disimpan.'
        ]);
    }

    public function edit_ajax($id)
    {
        $profesi = ProfesiModel::find($id);
        $categories = CategoryModel::all();

        return view('admin.profesi.edit_ajax', compact('profesi', 'categories'));
    }

    // Update data profesi via ajax
    public function updateAjax(Request $request, $id)
    {
        // Cari data profesi berdasarkan id
        $profesi = ProfesiModel::find($id);

        if (!$profesi) {
            return response()->json([
                'status' => false,
                'message' => 'Data profesi tidak ditemukan.',
            ]);
        }

        // Validasi input
        $rules = [
            'nama_profesi' => 'required|string|min:3|max:100',
            'category_id' => 'required|exists:category,category_id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        // Update data
        $profesi->nama_profesi = $request->nama_profesi;
        $profesi->category_id = $request->category_id;
        $profesi->save();

        return response()->json([
            'status' => true,
            'message' => 'Data profesi berhasil diperbarui.'
        ]);
    }
}
