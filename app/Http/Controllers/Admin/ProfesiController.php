<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfesiModel;
use App\Models\CategoryModel;
use Yajra\DataTables\DataTables;

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
}
