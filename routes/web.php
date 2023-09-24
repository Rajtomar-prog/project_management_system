<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;


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

Auth::routes();

Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/department_users', [App\Http\Controllers\ProjectController::class, 'department_users']);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('admin/roles', App\Http\Controllers\RoleController::class);
    Route::resource('admin/users', App\Http\Controllers\UserController::class);
    Route::resource('admin/products', App\Http\Controllers\ProductController::class);
    Route::resource('admin/departments', App\Http\Controllers\DepartmentController::class);
    Route::resource('admin/projects', App\Http\Controllers\ProjectController::class);
    Route::resource('admin/status', App\Http\Controllers\StatusController::class);

    Route::get('admin/tasks/get_assigned_users', [App\Http\Controllers\TaskController::class,'get_assigned_users'])->name('get_assigned_users');
    Route::get('admin/tasks/get_task_detail', [App\Http\Controllers\TaskController::class,'get_task_detail'])->name('get_task_detail');
    Route::resource('admin/tasks', App\Http\Controllers\TaskController::class);

    Route::get('admin/profile', [App\Http\Controllers\ProfileController::class,'index'])->name('profile');
    
    Route::resource('admin/clients', App\Http\Controllers\ClientController::class);
    Route::get('admin/users/user-profile-by-role/{id}', [App\Http\Controllers\UserController::class, 'userProfileByRole'])->name('userProfileByRole');
});
