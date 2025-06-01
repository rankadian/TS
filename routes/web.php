<?php

use App\Http\Controllers\AdminController;
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
    Route::middleware(['auth:admin', 'authorize.user:ADM'])->group(function () {
        Route::group(['prefix' => 'admin'], function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin.index');
            Route::post('/list', [AdminController::class, 'list']);
            Route::get('/{id}/show_ajax', [AdminController::class, 'show_ajax']);
            Route::get('/user/create_ajax', [AdminController::class, 'create_ajax']);
            Route::get('/{id}/edit_ajax', [AdminController::class, 'edit_ajax']);
            Route::post('/ajax', [AdminController::class, 'store_ajax']);
            Route::put('/{id}/update_ajax', [AdminController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [AdminController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [AdminController::class, 'delete_ajax']);
        });
    });

    // route for alumni
    // Route::middleware(['auth:alumni', 'authorize.user:AMI'])->group(function () {
    //     Route::group(['prefix' => 'alumni'], function () {
    //         Route::get('/', [AdminController::class, 'index']);
    //     });
    // });
});
