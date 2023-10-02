<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('admin.profile.index', compact('user'));
    }

    public function create(){
        return 'create profile';
    }

    public function store(Request $request){
        return 'Create new profile';
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required|numeric|digits:10',
            'profile_pic' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        
        if($request->hasFile('profile_pic')){
            $path = 'admin-assets/dist/img/'.$user->profile_pic;
            if(File::exists($path)){
                File::delete($path);
            }
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('admin-assets/dist/img/', $filename);
            $user->profile_pic = $filename;
            
        }

        $user->update();

        return redirect('admin/profile')->with('success', 'Profile updated successfully!');
    }

    public function destroy($id){
    }
}
