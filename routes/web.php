<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SettingController;

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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth','verified']], function() {

    Route::get('admin/home', [HomeController::class, 'index'])->name('home');
    Route::get('admin', [HomeController::class, 'index'])->name('home');
    Route::get('admin/department_users', [ProjectController::class, 'department_users']);
    Route::resource('admin/roles', RoleController::class);
    Route::resource('admin/users', UserController::class);
    Route::resource('admin/products', ProductController::class);
    Route::resource('admin/departments', DepartmentController::class);
    Route::resource('admin/projects', ProjectController::class);
    Route::resource('admin/status', StatusController::class);

    Route::get('admin/tasks/get_assigned_users', [TaskController::class,'get_assigned_users'])->name('get_assigned_users');
    Route::get('admin/tasks/get_task_detail', [TaskController::class,'get_task_detail'])->name('get_task_detail');
    Route::get('admin/tasks/add_comment', [TaskController::class,'add_comment'])->name('add_comment');
    Route::get('admin/tasks/destroy_comment', [TaskController::class,'destroy_comment'])->name('destroy_comment');
    Route::get('admin/tasks/change_task_status', [TaskController::class,'change_task_status'])->name('change_task_status');
    Route::get('admin/tasks/update_assignee', [TaskController::class,'update_assignee'])->name('update_assignee');
    Route::resource('admin/tasks', TaskController::class);

    Route::resource('admin/profile', ProfileController::class);
    
    // Route::resource('admin/clients', ClientController::class);
    Route::get('admin/users/user-profile-by-role/{id}', [UserController::class, 'userProfileByRole'])->name('userProfileByRole');

    Route::resource('admin/permissions', PermissionController::class);

    Route::resource('admin/settings', SettingController::class);
});
