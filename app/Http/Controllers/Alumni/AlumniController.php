<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
     public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Welcome to Tracer Study POLINEMA',
            'list' => ['Home', 'Welcome']
        ];

        $page = (object)[
            'title' => 'List of alumni registered in the system'
        ];

        $activeMenu = 'alumni';
        $alumni = AlumniModel::all();
        return view('alumni.dashboard.index', ['breadcrumb' => $breadcrumb, 'alumni' => $alumni, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
}
