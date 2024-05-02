<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $departments = Department::count();
        $projects = Project::count();
        $tasks = Task::count();
        $users = User::count();
        $roles = Role::count();
        $permissions = Permission::count();
        
        return view('admin.dashboard', compact('departments','projects','tasks','users','roles','permissions'));
    }
}
