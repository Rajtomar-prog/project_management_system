<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Status;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class TaskController extends Controller
{
    public function index()
    {

        if (isset($_GET['project_id']) && !empty($_GET['project_id'])) {
            $project_id = array($_GET['project_id']);
        } else {
            $project_id = Project::orderBy('id', 'desc')->limit(1)->get()->pluck('id');
        }

        $statuses = Status::orderBy('order', 'ASC')->get();
 
        $statusData = [];
        foreach ($statuses as $key => $row) {
            $statusData[$key] = [
                'id' => $row->id,
                'name' => $row->name,
                'color' => $row->color
            ];
            $tasks = Task::where(['project_id' => $project_id, 'status_id' => $row->id])->get();
            if ($tasks->isNotEmpty()) { 
                foreach ($tasks as $task) {
                    $statusData[$key]['tasks'][] = [
                        'task_id' => $task->id,
                        'task_name' => $task->title,
                        'description' => $task->description
                    ];
                }
            }else{
                $statusData[$key]['tasks'][] = ['task_id'=>'','task_name'=>''];
            }
        }

        $projects = Project::all()->pluck('project_name', 'id')->toArray();

        return view('admin.tasks.index', compact('statuses', 'projects', 'project_id','statusData'));
    }

    public function get_task_detail(Request $request)
    {
    
        $response = collect([]);

        $task = Task::find($request->task_id);
        $users = $task->users;
        $status = $task->status;
        $status_name = $status->name;

        $priority = taskPriority($task->priority);

        $created_by = getUserNameById($task->created_by);
        
        //$status = false;
        // if($task){
        //     $response->push([
        //         'task' => $task
        //     ]); 
        //     $status = true;
        // }

        echo '

        <div class="row">
            <div class="col-sm-8" style="overflow-y: scroll; height:400px;">
                <div class="card-body" style="padding: 0px;">
                    <div class="card card-light card-outline">
                        <div class="card-header">
                            <h5 class="card-title">'.$task->title.'</h5>
                        </div>
                        <div class="card-body" style="padding: 10px;">
                            <div>
                                '.$task->description.'
                            </div>
                            <div class="panel panel-default widget">
                                <div class="panel-heading card-header">
                                    <h5 class="card-title">
                                        <i class="fa fa-comments" aria-hidden="true"></i>
                                        Comments
                                    </h5>
                                    <span class="label label-info badge badge-info">78</span>
                                </div>
                                <div class="panel-body">
                                    <ul class="list-group">';
                                        for($i=1; $i<=5; $i++){
                                        echo '<li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <img src="http://127.0.0.1:8000/admin-assets/dist/img/user4-128x128.jpg" class="img-circle img-responsive" width="100%" alt="" />
                                                </div>
                                                <div class="col-sm-11">
                                                    <div class="mic-info">
                                                        <a href="#">Bhaumik Patel</a> <small>2 Aug 2023</small>
                                                    </div>
                                                    <div class="comment-text">
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                    </div>
                                                    <div class="action">
                                                        <button type="button" class="btn badge badge-info" title="Edit">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btn btn badge badge-danger" title="Delete">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>';
                                        }
                                    echo '
                                    </ul>
                                    <div class="form-group">
                                        <strong>Add a comment:</strong>
                                        <textarea name="description" placeholder="Enter description" id="summernote" class="form-control"></textarea>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-flat">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" style="overflow-y: scroll; height:400px;">
                <div class="card-body" style="padding: 0px;">
                    <div class="card card-light card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Assignee</h5>
                        </div>
                        <div class="card-body" style="padding: 10px;">
                            <ul class="list-group assignee">';

                                foreach($users as $user){

                                echo '<li class="list-group-item">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <img src="http://127.0.0.1:8000/admin-assets/dist/img/user4-128x128.jpg" class="img-circle img-responsive" width="100%" alt="" />
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="mic-info">
                                                '.$user["name"].'
                                            </div>
                                        </div>
                                    </div>
                                </li>';

                                }

                            echo '
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 0px;">
                    <div class="card card-light card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Settings</h5>
                        </div>
                        <div class="card-body settings-box">
                            <div class="jumbotron bg-default">
                                <b><i class="fa fa-calendar-check" aria-hidden="true"></i> Due Date:</b> '.changeDateFormat('M d, Y',$task->due_date).'
                            </div>
                            <div class="jumbotron bg-default">
                                <b><i class="fa fa-flag" aria-hidden="true"></i> Status:</b> '.$status_name.'
                            </div>
                            <div class="jumbotron bg-default">
                                <b><i class="fa fa-bell" aria-hidden="true"></i> Priority:</b> '.$priority.'
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 0px;">
                    <div class="card card-light card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Information</h5>
                        </div>
                        <div class="card-body" style="padding: 10px;">
                            <div class="table-responsive">
                                <table class="table info-table">
                                    <tbody>
                                        <tr>
                                            <td>Created By</td>
                                            <td>: '.$created_by.'</td>
                                        </tr>
                                        <tr>
                                            <td>Created on</td>
                                            <td>: '.changeDateFormat('M d, Y',$task->created_at).'</td>
                                        </tr>
                                        <tr>
                                            <td>Project</td>
                                            <td>: '.getProjectNameById($task->project_id).'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        ';

        //return response()->json(['status' => $status, 'data' => $response]);
        die();
    }

    public function create()
    {
        $projects = Project::all()->pluck('project_name', 'id')->toArray();
        $priority = array('' => 'Select Priority', 1 => 'Highest', 2 => 'High', 3 => 'Low', 4 => 'Lowest');
        $statuses = Status::all()->sortBy('order')->pluck('name', 'id');
        return view('admin.tasks.create', compact('priority', 'projects', 'statuses'));
    }

    public function get_assigned_users(Request $request)
    {
        $status = false;
        $response = collect([]);
        if (!empty($request->projectID)) {
            $userProject = Project::find($request->projectID);
            $usersp = $userProject->users;
            foreach ($usersp as $user) {
                $response->push([
                    'id' => $user->id,
                    'text' => $user->name,
                ]);
            }
            $status = true;
        }
        return response()->json(['status' => $status, 'data' => $response]);
        die();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'priority' => 'required',
            'project_id' => 'required',
            'users' => 'required',
            'due_date' => 'required',
            'status_id' => 'required',
            'description' => 'required',
            'created_by' => 'required'
        ]);

        $input = $request->all();
        $input = Arr::except($input, array('users'));

        $task = Task::create($input);
        $task->users()->attach($request->users);

        return redirect('admin/tasks')->with('success', 'Project created successfully');
    }

    public function show(string $id)
    {
        return 'show';
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
