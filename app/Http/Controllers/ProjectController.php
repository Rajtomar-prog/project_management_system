<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\User;
use App\Models\Department;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create(){

        $clients = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Client');
            }
        )->get()->pluck('name','id')->toArray();

        $users = User::whereHas(
            'roles', function($q){
                $q->where('name','!=','Client');
                $q->where('name','!=','Admin');
            }
        )->get()->pluck('name','id');

        $departments = Department::pluck('name','id')->all();
        return view('admin.projects.create',compact('clients','users','departments'));
    }

    
    public function store(Request $request){
        
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
        $input = Arr::except($input,array('departments'));
        $input = Arr::except($input,array('users'));

        $project = Project::create($input);
        $project->users()->attach($request->users);
        $project->departments()->attach($request->departments);

        return redirect('admin/projects')->with('success','Project created successfully');
    }

    public function show($id)
    {
        $project = Project::find($id);
        return view('admin.projects.show',compact('project'));
    }

    public function department_users(Request $request)
    {
        $departments = Department::find($request->department);
        $users = $departments->users;
    
        return $users;

        $response = collect([]);

        foreach ($users as $user) {
            $response->push([
                'id' => $user->id,
                'text' => $user->name,
            ]);
        }

        return response()->json($response);
    }
}
