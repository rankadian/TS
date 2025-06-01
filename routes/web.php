<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataAlumniController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;


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
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // route for admin
    Route::middleware(['auth:admin', 'authorize.user:ADM'])->prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        Route::post('/list', [DashboardController::class, 'list']);
        Route::get('/{id}/show_ajax', [DashboardController::class, 'show_ajax']);
        Route::get('/user/create_ajax', [DashboardController::class, 'create_ajax']);
        Route::get('/{id}/edit_ajax', [DashboardController::class, 'edit_ajax']);
        Route::post('/ajax', [DashboardController::class, 'store_ajax']);
        Route::put('/{id}/update_ajax', [DashboardController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [DashboardController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [DashboardController::class, 'delete_ajax']);
    });

     // route for alumni
    // Route::middleware(['auth:alumni', 'authorize.user:AMI'])->group(function () {
    //     Route::group(['prefix' => 'alumni'], function () {
    //         Route::get('/', [AdminController::class, 'index']);
    //     });
    // });
});
