<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Department;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:project-list|project-create|project-edit|project-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:project-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:project-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:project-delete', ['only' => ['destroy']]); 
    }

    public function index()
    {
        if(isAdmin()){
            $projects = Project::latest()->paginate(10);
        }else{
            $projects = Auth::user()->projects()->paginate(10);
        }

        return view('admin.projects.index', compact('projects'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {

        $clients = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'Client');
            }
        )->get()->pluck('name', 'id')->toArray();

        $departments = Department::pluck('name', 'id')->all();
        return view('admin.projects.create', compact('clients', 'departments'));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'project_name' => 'required',
            'client_id' => 'required',
            'departments' => 'required',
            'users' => 'required',
            'budget' => 'required|numeric',
            'budget_type' => 'required',
            'curency' => 'required',
            'status' => 'required',
            'description' => 'required'
        ]);

        $input = $request->all();
        $input = Arr::except($input, array('departments'));
        $input = Arr::except($input, array('users'));

        $project = Project::create($input);
        $project->users()->attach($request->users);
        $project->departments()->attach($request->departments);

        return redirect('admin/projects')->with('success', 'Project created successfully');
    }

    public function show($id)
    {
        $project = Project::find($id);
        return view('admin.projects.show', compact('project'));
    }

    public function department_users(Request $request)
    {
        $status = false;
        $response = collect([]);
        if (!empty($request->department)) {
            $departments = Department::find($request->department);
            $depUsers = $departments->load(['users']);

            foreach ($depUsers as $department) {
                foreach ($department->users as $user) {
                    
                    $response->push([
                        'id' => $user->id,
                        'text' => $user->name,
                    ]);
                }
            }
            $status = true;
        }

        return response()->json(['status' => $status, 'data' => $response->unique()]);
        die();
    }

    public function edit($id){
        $project = Project::find($id);

        $clients = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'Client');
            }
        )->get()->pluck('name', 'id')->toArray();

        $departments = Department::pluck('name', 'id')->all();
        $projectDepartments = $project->departments;

        $users = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', '!=', 'Client');
                $q->where('name', '!=', 'Admin');
            }
        )->get()->pluck('name', 'id');

        $projectUsers = $project->users;

        return view('admin.projects.edit',compact('project','clients','departments','projectDepartments', 'users','projectUsers'));

    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'project_name' => 'required',
            'client_id' => 'required',
            'departments' => 'required',
            'users' => 'required',
            'budget' => 'required|numeric',
            'budget_type' => 'required',
            'curency' => 'required',
            'status' => 'required',
            'description' => 'required'
        ]);

        $input = $request->all();
        $input = Arr::except($input, array('departments'));
        $input = Arr::except($input, array('users'));

        $project = Project::find($id);
        $project->update($input);

        $project->users()->detach();
        $project->users()->attach($request->users);
        
        $project->departments()->detach();
        $project->departments()->attach($request->departments);

        return redirect('admin/projects')->with('success','Project updated successfully');
    }

    public function destroy($id)
    {
        Project::find($id)->delete();
        return redirect('admin/projects')->with('success','Project deleted successfully');
    }



}
