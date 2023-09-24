<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{

    public function index()
    {
        $statuses = Status::latest()->paginate(10);
        return view('admin.status.index', compact('statuses'))
            ->with('i', (request()->input('page', 1) - 1) * 10);

    }

    public function create()
    {
        $order = array('' => 'Select Order', 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
        return view('admin.status.create', compact('order'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'order' => 'required|numeric',
            'color' => 'required',
            'is_active' => 'required'
        ]);
        
        Status::create($request->all());
        return redirect('admin/status')->with('success', 'Status created successfully');
    }

    public function show(Status $status)
    {
        //
    }

    public function edit($id)
    {
        $status = Status::find($id);
        $order = array('' => 'Select Order', 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
        return view('admin.status.edit', compact('status', 'order'));
    }

    public function update(Request $request, Status $status)
    {
        $this->validate($request, [
            'name' => 'required',
            'order' => 'required|numeric',
            'color' => 'required',
            'is_active' => 'required'
        ]);

        $status->update($request->all());

        return redirect('admin/status')->with('success', 'Task status updated successfully');
    }

    public function destroy(Status $status)
    {
        //
    }
}
