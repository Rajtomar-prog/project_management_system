<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::latest()->paginate(10);
        return view('admin.permissions.index', compact('permissions'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get All Models
        $path = app_path('Models') . '/*.php';
        $models = collect(glob($path))->map(fn ($file) => basename($file, '.php'))->toArray();
        return view('admin.permissions.create',compact('models'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|unique:permissions,name',
            'guard_name' => 'required'
        ]);
        Permission::create($request->all());
        return redirect('admin/permissions')->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('admin.permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name,'.$id,
            'guard_name' => 'required'
        ]);

        $input = $request->all();

        $permission = Permission::find($id);
        $permission->update($input);

        return redirect('admin/permissions')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        Permission::find($id)->delete();
        return redirect('admin/permissions')->with('success','Permission deleted successfully.');
    }
}
