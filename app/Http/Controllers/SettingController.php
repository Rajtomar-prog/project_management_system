<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:setting-list|setting-create|setting-edit|setting-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:setting-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:setting-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:setting-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $setting = Setting::find(1);
        return view('admin.settings.index', compact('setting'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Setting $setting)
    {
        //
    }

    public function edit(Setting $setting)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'app_name' => 'required',
            'company_name' => 'required',
            'company_email' => 'required|email|unique:settings,company_email,'.$id,
            'company_phone' => 'required|numeric|digits:10',
            'address' => 'required',
            'app_logo' => 'image|mimes:jpeg,png,jpg|max:2048',
            'favicon' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        $input = $request->all();
 
        $setting = Setting::find($id);

        if($request->hasFile('app_logo')){
            $path = 'admin-assets/dist/img/settings/'.$setting->app_logo;
            if(File::exists($path)){
                File::delete($path);
            }
            $file = $request->file('app_logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('admin-assets/dist/img/settings/', $filename);
            $input['app_logo'] = $filename;
        }

        if($request->hasFile('favicon')){
            $path = 'admin-assets/dist/img/settings/'.$setting->favicon;
            if(File::exists($path)){
                File::delete($path);
            }
            $file = $request->file('favicon');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('admin-assets/dist/img/settings/', $filename);
            $input['favicon'] = $filename;
        }

        $setting->update($input);
    
        return redirect('admin/settings')->with('success','Settings updated successfully');
    }

    public function destroy(Setting $setting)
    {
        //
    }
}
