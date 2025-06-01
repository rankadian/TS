<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel; // Pastikan model ini sudah ada
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataAlumniController extends Controller
{
    public function index()
    {
        $page = (object) ['title' => 'Data Alumni'];
        return view('admin.data.index', compact('page'));
    }

    public function list(Request $request)
    {
        $query = AlumniModel::select([
            'id',
            'tahun_lulus',
            'name',
            'no_hp',
            'email',
            'email_verified_at',
        ]);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($alumni) {
                // Contoh tombol edit dan delete (sesuaikan url dan class css)
                $editUrl = url('admin/alumni/edit/' . $alumni->id);
                $deleteUrl = url('admin/alumni/delete/' . $alumni->id);
                return '
                    <button onclick="modalAction(\'' . $editUrl . '\')" class="btn btn-sm btn-primary">Edit</button>
                    <button onclick="deleteConfirm(\'' . $deleteUrl . '\')" class="btn btn-sm btn-danger">Delete</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function createAjax()
    {
        return view('admin.alumni.create_ajax'); // Buat form modal create alumni di sini
    }
}
