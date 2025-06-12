<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel;
use Illuminate\Http\Request;
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
            'title' => 'My Profile'
        ];

        $activeMenu = 'alumni';

        $user = auth('alumni')->user();

        return view('alumni.dashboard.index', compact('breadcrumb', 'page', 'activeMenu', 'user'));
    }

    public function edit_ajax(string $id)
    {
        $alumni = AlumniModel::find($id);
        return view('alumni.dashboard.edit_ajax', ['alumni' => $alumni]);
    }

    public function update_ajax(Request $request, $id)
    {
        $alumni = AlumniModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'no_hp' => 'nullable|string|min:8',
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
