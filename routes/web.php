<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataAlumniController;
use App\Http\Controllers\Admin\ProfesiController;
use App\Http\Controllers\Alumni\AlumniController;
use App\Http\Controllers\Alumni\TracerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;
use Symfony\Component\HttpKernel\Controller\TraceableControllerResolver;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//landing page
Route::get('/', function () {
    return view('landing');
});

// auth
Route::pattern('id', '[0-9]+');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:admin', 'authorize.user:ADM'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        // route for manage alumni data
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        Route::post('/list', [DashboardController::class, 'list']);
        Route::get('/{id}/show_ajax', [DashboardController::class, 'show_ajax']);
        Route::get('/user/create_ajax', [DashboardController::class, 'create_ajax']);
        Route::get('/{id}/edit_ajax', [DashboardController::class, 'edit_ajax']);
        Route::post('/ajax', [DashboardController::class, 'store_ajax']);
        Route::put('/{id}/update_ajax', [DashboardController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [DashboardController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [DashboardController::class, 'delete_ajax']);

        // route for manage alumni data from admin
        Route::get('/data-alumni', [DataAlumniController::class, 'index'])->name('admin.dataalumni.index');
        Route::post('/data-alumni/list', [DataAlumniController::class, 'list'])->name('admin.dataalumni.list');
        // Route::get('/data-alumni/create_ajax', [DataAlumniController::class, 'create_ajax'])->name('admin.dataalumni.create_ajax');
        Route::post('/data-alumni/ajax', [DataAlumniController::class, 'store_ajax'])->name('admin.dataalumni.store_ajax');
        Route::get('/data-alumni/{id}/show_ajax', [DataAlumniController::class, 'show_ajax'])->name('admin.dataalumni.show_ajax');
        Route::get('/data-alumni/{id}/edit_ajax', [DataAlumniController::class, 'edit_ajax'])->name('admin.dataalumni.edit_ajax');
        Route::put('/data-alumni/{id}/update_ajax', [DataAlumniController::class, 'update_ajax'])->name('admin.dataalumni.update_ajax');
        Route::get('/data-alumni/{id}/delete_ajax', [DataAlumniController::class, 'confirm_ajax'])->name('admin.dataalumni.confirm_ajax');
        Route::delete('/data-alumni/{id}/delete_ajax', [DataAlumniController::class, 'delete_ajax'])->name('admin.dataalumni.delete_ajax');
        Route::get('/data-alumni/import', [DataAlumniController::class, 'import'])->name('admin.dataalumni.import');
        Route::post('/data-alumni/import_ajax', [DataAlumniController::class, 'import_ajax'])->name('admin.dataalumni.import_ajax');

        // route for manage profession
        Route::get('/profesi', [ProfesiController::class, 'index'])->name('admin.profesi.index');
        Route::post('/profesi/list', [ProfesiController::class, 'list'])->name('admin.profesi.list');
        Route::get('/profesi/create_ajax', [ProfesiController::class, 'create_ajax'])->name('admin.profesi.create_ajax');
        Route::get('/profesi/{id}/show_ajax', [ProfesiController::class, 'show_ajax']);
        Route::post('/profesi/store_ajax', [ProfesiController::class, 'store_ajax']);
        Route::get('/profesi/{id}/edit_ajax', [ProfesiController::class, 'edit_ajax'])->name('profesi.edit_ajaxt');
        Route::put('/profesi/{id}/update_ajax', [ProfesiController::class, 'updateAjax'])->name('profesi.update_ajax');
        Route::get('/profesi/{id}/confirm_ajax', [ProfesiController::class, 'confirmDeleteAjax'])->name('profesi.confirm_ajax');
        Route::delete('/profesi/{id}/delete_ajax', [ProfesiController::class, 'deleteAjax'])->name('profesi.delete_ajax');
    });
});

// route for alumni
Route::middleware(['auth:alumni', 'authorize.user:AMI'])->group(function () {
    Route::group(['prefix' => 'alumni'], function () {
        // route for alumni dashboard
        Route::get('/', [AlumniController::class, 'index'])->name('alumni.dashboard.index');
        Route::get('/dashboard', [AlumniController::class, 'dashboard_welcome'])->name('alumni.dashboard.welcome');
        Route::post('/list', [AlumniController::class, 'list']);
        Route::get('/{id}/show_ajax', [AlumniController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [AlumniController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [AlumniController::class, 'update_ajax']);

        // route tracer
        Route::get('/tracer', [TracerController::class, 'index'])->name('alumni.tracer.index');
        Route::get('/tracer/edit-ajax/{id}', [TracerController::class, 'edit_ajax'])->name('alumni.tracer.edit_ajax');
        Route::get('/tracer/confirm-ajax/{id}', [TracerController::class, 'confirm_ajax'])->name('alumni.tracer.confirm_ajax');
        Route::get('/tracer/show-ajax/{id}', [TracerController::class, 'show_ajax'])->name('alumni.tracer.show_ajax');
        Route::post('/tracer/store-ajax', [TracerController::class, 'store_ajax'])->name('alumni.tracer.store_ajax');
        Route::post('/tracer/update-ajax/{id}', [TracerController::class, 'update_ajax'])->name('alumni.tracer.update_ajax');
    });
});
