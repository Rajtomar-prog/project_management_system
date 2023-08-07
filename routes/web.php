<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::group(['middleware' => ['auth']], function() {
    Route::resource('admin/roles', App\Http\Controllers\RoleController::class);
    Route::resource('admin/users', App\Http\Controllers\UserController::class);
    Route::resource('admin/products', App\Http\Controllers\ProductController::class);
    Route::resource('admin/departments', App\Http\Controllers\DepartmentController::class);
});
