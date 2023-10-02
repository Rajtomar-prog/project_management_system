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
    function __construct()
    {
        $this->middleware('permission:task-list|task-create|task-edit|task-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:task-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]); 
    }

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
                        'description' => $task->description,
                        'project_id' => $task->project_id,
                        'created_at' => $task->created_at
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

        $task = Task::find($request->task_id);
        $users = $task->users;

        $userIds = [];
        foreach($users as $user){
            $userIds[] = $user->id;
        }

        $project = Project::find($request->project_id);
        $project_users = $project->users;

        $status = $task->status;
        $status_name = $status->name;
        $status_id = $status->id;
        $statuses = Status::orderBy('order', 'ASC')->get();

        $comments = $task->comments;
        
        $priority = taskPriority($task->priority);
        $created_by = getUserNameById($task->created_by);
        
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
                                                    <img src="'.get_profile_pic($comment->commented_by).'" class="img-circle img-responsive" width="100%" alt="" />
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
                                                        <button type="button" data-id="'.$comment->id.'" data-task_id="'.$task->id.'" class="btn btn badge badge-danger delete_comment" title="Delete">
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
                        <div class="card-body">
                            <div class="assignee-section">
                                <ul class="list-group assignee">';
                                    foreach($users as $user){
                                        echo '<li class="list-group-item">
                                            <div class="user-dp">
                                                <img src="'.get_profile_pic($user->id).'" class="img-circle img-responsive" width="100%" alt="'.$user->name.'" title="'.$user->name.'" />
                                            </div>
                                        </li>';
                                    }
                                    echo '
                                </ul>
                                <button class="btn assign_task_user"><i class="fa fa-plus"></i></button>
                                
                            </div>
                            <div class="assign_task_users">
                                <select name="users[]" class="select2" multiple="multiple" id="update_assignee" data-task_id="'.$task->id.'" data-placeholder="Select users" style="width: 100%;">';
                                    foreach($project_users as $users){
                                        $sel = '';
                                        if(in_array($users->id,$userIds)){ $sel = 'selected'; } 
                                        echo '<option value="'.$users->id.'" '.$sel.'>'.$users->name.'</option>';
                                    }
                                echo '
                                </select>
                            </div>
                            <script>
                                $(".select2").select2()
                            </script>
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
                                <div class="display-status">
                                    <b><i class="fa fa-flag" aria-hidden="true"></i> Status:</b> '.$status_name.'
                                </div>
                                <div class="status-section">
                                    <select name="statuses" class="form-control change_task_status" data-task_id="'.$task->id.'">';
                                        foreach($statuses as $status){
                                            $sel='';
                                            if($status->id==$status_id){ $sel = 'selected';}
                                            echo '<option value="'.$status->id.'" '.$sel.'>'.$status->name.'</option>';
                                        } echo '
                                    </select>
                                </div>
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

    public function destroy_comment(Request $request){
   
        $isDeleted = Comment::find($request->id)->delete($request->id);
        if($isDeleted){
            $status = true;
            return response()->json(['status' => $status,'msg' => 'Comment deleted successfully!']);
        }else{
            $status = false;
            return response()->json(['status' => $status,'msg' => 'OOps! Something went wrong.']);
        }
        die();
    }

    public function change_task_status(Request $request){
        $task = Task::find($request->task_id);
        $task->status_id = $request->id;
        $isSave = $task->save();
        if($isSave){
            $status = true;
            return response()->json(['status' => $status,'msg' => 'Task Status updated successfully!']);
        }else{
            $status = false;
            return response()->json(['status' => $status,'msg' => 'OOps! Something went wrong.']);
        }
        die();
    }

    public function update_assignee(Request $request){

        $this->validate($request, [
            'task_id' => 'required',
            'userIds' => 'required',
        ]);

        $task = Task::find($request->task_id);

        $task->users()->detach();
        $task->users()->attach($request->userIds);

        return response()->json(['status' => true,'msg' => 'Assignee updated successfully!']);
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

        $redirect_url = 'admin/tasks?project_id='.$request->project_id;

        return redirect($redirect_url)->with('success', 'Task created successfully');
    }

    public function show(string $id)
    {
        return 'show';
    }

    public function edit($id)
    {
        $task = Task::find($id);
        $taskUsers = $task->users;

        $project = Project::find($task->project_id);
        $projectUsers = $project->users->pluck('name','id');
       
        $projects = Project::all()->pluck('project_name', 'id')->toArray();
        $priority = array('' => 'Select Priority', 1 => 'Highest', 2 => 'High', 3 => 'Low', 4 => 'Lowest');
        $statuses = Status::all()->sortBy('order')->pluck('name', 'id');
        return view('admin.tasks.edit', compact('task','projectUsers','taskUsers','priority', 'projects', 'statuses'));
    }

    public function update(Request $request, $id)
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

        $task = Task::find($id);
        $task->update($input);

        $task->users()->detach();
        $task->users()->attach($request->users);

        $redirect_url = 'admin/tasks?project_id='.$request->project_id;

        return redirect($redirect_url)->with('success', 'Task updated successfully');
    }

    public function destroy($id)
    {
        Task::find($id)->delete();
        return back()->with('success','Task deleted successfully!');
    }
}
