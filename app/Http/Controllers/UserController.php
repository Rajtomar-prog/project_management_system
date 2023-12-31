<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]); 
    }
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(10);
        return view('admin.users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function userProfileByRole(Request $request){

        $data = User::whereHas(
            'roles', function($q)use($request){
                $q->where('id', $request->id);
            }
        )->paginate(10);

        return view('admin.users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 10);;
    }
    
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $departments = Department::pluck('name','id')->all();
        return view('admin.users.create',compact('roles','departments'));
    }
    
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            // 'departments' => 'required',
            'phone_number' => 'required|numeric|digits:10',
            'profile_pic' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        $input = $request->all();
        
        $input['password'] = Hash::make($input['password']);
    
        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('admin-assets/dist/img/', $filename);
            $input['profile_pic'] = $filename;  
        }

        $user = User::create($input);

        $user->assignRole($request->input('roles'));

        $user->departments()->attach($request->departments);
    
        return redirect('admin/users')->with('success','User created successfully');
    }
    
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show',compact('user'));
    }
    
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        $departments = Department::pluck('name','id')->all();
        $userDepartments = $user->departments;
 
        return view('admin.users.edit',compact('user','roles','userRole','departments','userDepartments'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            // 'departments' => 'required',
            'phone_number' => 'required|numeric|digits:10',
            'profile_pic' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);

        if($request->hasFile('profile_pic')){
            $path = 'admin-assets/dist/img/'.$user->profile_pic;
            if(File::exists($path)){
                File::delete($path);
            }
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('admin-assets/dist/img/', $filename);
            $input['profile_pic'] = $filename;
        }

        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));

        $user->departments()->detach();
        $user->departments()->attach($request->departments);
    
        return redirect('admin/users')->with('success','User updated successfully');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('admin/users')->with('success','User deleted successfully');
    }
}
