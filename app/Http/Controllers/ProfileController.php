<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(){
        $user = auth()->user();
        // $userID = auth()->user()->id; 
        // $user = User::find($userID);
        return view('admin.profile.index',compact('user'));
    }
}
