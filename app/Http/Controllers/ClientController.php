<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class ClientController extends Controller
{
    public function index(Request $request){

        $data = User::whereHas(
            'roles', function($q)use($request){
                $q->where('id', 5);
            }
        )->paginate(10);

        return view('admin.clients.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.clients.create',compact('roles'));
    }
}
