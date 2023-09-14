<?php

namespace App\Http\Controllers;
use App\Models\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TaskController extends Controller
{
    public function index()
    {
        // $tasks = Task::latest()->paginate(10);
        // return view('admin.tasks.index', compact('tasks'))
        //     ->with('i', (request()->input('page', 1) - 1) * 10);
        
        return view('admin.tasks.index');
    }
    public function status(){
        return 'status';
    }
}
