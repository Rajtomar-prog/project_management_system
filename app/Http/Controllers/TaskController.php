<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Status;
use App\Models\Project;
use App\Models\Comment;
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
    
        // $response = collect([]);

        $task = Task::find($request->task_id);
        $users = $task->users;
        $status = $task->status;
        $status_name = $status->name;

        // $user = auth()->user();
        // $user_id = auth()->user()->id; 
       
        // $comment = new Comment;
        // $comment->comment = "My Third Comment";
        // $comment->commented_by = $user_id;
        // return $task = $task->comments()->save($comment);

        $comments = $task->comments;
        
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
                                    <span class="label label-info badge badge-info">'.count($comments).'</span>
                                </div>
                                <div class="panel-body">
                                    <br>
                                    <small id="comment_error" class="form-text text-danger"></small>
                                    <small id="task_id_error" class="form-text text-danger"></small>
                                    <input type="hidden" name="task_id" class="form-control task_id" value="'.$task->id.'">
                                    <div class="form-group">
                                        <strong>Add a comment:</strong>
                                        <textarea name="comment" placeholder="Enter description" id="summernote" class="form-control comment"></textarea>
                                    </div>
                                    <button type="button" id="add_comment" class="btn btn-outline-primary btn-block btn-sm">Save</button>
                                    <br>
                                    <script>
                                        $(function () {
                                            $("#summernote").summernote();
                                        });
                                    </script>

                                    <ul class="list-group">';
                                        foreach($comments as $comment){
                                        echo '<li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <img src="http://127.0.0.1:8000/admin-assets/dist/img/user4-128x128.jpg" class="img-circle img-responsive" width="100%" alt="" />
                                                </div>
                                                <div class="col-sm-11">
                                                    <div class="mic-info">
                                                        <a href="#">'.getUserNameById($comment->commented_by).'</a> <small>'.changeDateFormat('M d, Y h:i A',$comment->created_at).'</small>
                                                    </div>
                                                    <div class="comment-text">
                                                        '.$comment->comment.'
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
                            <h5 class="card-title"><i class="fa fa-users"></i> Assignee</h5>
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
                            <h5 class="card-title"><i class="fa fa-cogs"></i> Settings</h5>
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
                            <h5 class="card-title"><i class="fa fa-info-circle"></i> Information</h5>
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

    public function add_comment(Request $request){

        $this->validate($request, [
            'task_id' => 'required',
            'comment' => 'required',
        ]);

        $task = Task::find($request->task_id);
       
        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->commented_by = auth()->user()->id; 
        $is_saved = $task->comments()->save($comment);

        $response = collect([]);

        $comments = $task->comments;
        if($is_saved){
            $response->push([
                'comments' => $comments
            ]); 
            $status = true;
        }else{
            $response->push([
                'comments' => $comments
            ]);
            $status = true;
        }

        return response()->json(['status' => $status,'data' => $response]);
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
