<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use DB;
use Session;
use Exception;
use Auth;
use Validator;
use File;
use Illuminate\Support\Facades\Storage;
use Hash;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Session("role_id");
        if($roles=="1"){
            $data["data"] = Role::orderBy("code", "asc")->get();
        }else{
            $data["data"] = Role::where("code", ">", "0")->orderBy("code", "asc")->get();
        }
        
        return view("role", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data["data"] = [];
        
        return view("form.role", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'bail|required|alpha_spaces|max:20|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.roles,name',
            'code'  => 'bail|required|numeric|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.roles,code',
            'description'  => 'bail|nullable|max:100',
            'is_self'  => 'bail|nullable',
            'picture'  => 'bail|nullable|image|mimes:jpg,png,jpeg,gif,svg|max:1024',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
        }
        
        try {
            DB::beginTransaction();
            $role                   = new Role();

            if($request->code=="0"){
                abort(404);
            }

            $role->name             = $request->name;
            $role->code             = $request->code;
            $role->description      = $request->description;
            $role->created_ip       = $request->ip();

            if(isset($role->is_self) and $request->is_self==1){
                $role->is_self = 1;
            }else{
                $role->is_self = 0;
            }

            if(isset(Auth::user()->user_id)){
                $role->created_by       = Auth::user()->user_id;
            }

            if(isset($request->gambar) and $request->file('gambar')!=null){
                $img = $request->file('gambar');
                
                $path_img = $img->store('roles');
                $image = explode("/", $path_img);
                $role->icon = $image[1];
            }

            $role->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data role Gagal Disimpan' )->withInput($request->input());;
        }
        
        return redirect("roles")->with('success', 'Data role Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        
        if(Storage::exists('roles/'.$role->icon)){
            $path = 'roles/'.$role->icon;
            
            $full_path = Storage::path($path);
            $base64 = base64_encode(Storage::get($path));
            $image = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
            $role->icon = $image;
        }
        
        $data["data"] = $role;
        return view("form.role", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        if($role->code=="0"){
            abort(404);
        }

        if(Storage::exists('roles/'.$role->icon)){
            $path = 'roles/'.$role->icon;

            $full_path = Storage::path($path);
            $base64 = base64_encode(Storage::get($path));
            $image = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
            $role->icon = $image;
        }

        $data["data"] = $role;
        return view("form.role", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'bail|required|alpha_spaces|max:20|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.roles,name,'.$id.',role_id',
            'code'  => 'bail|required|numeric|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.roles,code,'.$id.',role_id',
            'description'  => 'bail|nullable|max:100',
            'is_self'  => 'bail|nullable',
            'picture'  => 'bail|nullable|image|mimes:jpg,png,jpeg,gif,svg|max:1024',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
        }

        try {
            DB::beginTransaction();
            $role                   = Role::findOrFail($id);
            if($role->code=="0"){
                abort(404);
            }
            $role->name             = $request->name;
            $role->code             = $request->code;
            $role->description      = $request->description;
            $role->updated_ip       = $request->ip();
            
            if(isset($role->is_self) and $request->is_self==1){
                $role->is_self = 1;
            }else{
                $role->is_self = 0;
            }
            
            if(isset(Auth::user()->user_id)){
                $role->updated_by       = Auth::user()->user_id;
            }
            
            if(isset($request->gambar) and $request->file('gambar')!=null){
                if(Storage::exists('roles/'.$role->icon)){
                    Storage::delete('roles/'.$role->icon);
                }
                
                $img = $request->file('gambar');
                
                $path_img = $img->store('roles');
                $image = explode("/", $path_img);
                $role->icon = $image[1];
            }
            
            $role->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data role Gagal Disimpan' )->withInput($request->input());;
        }
        
        return redirect("roles")->with('success', 'Data role Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = null;
        try {

            DB::beginTransaction();
            $role                   = Role::findOrFail($id);
            if($role->code=="0"){
                abort(404);
            }
            $image = $role->icon;
            $role->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data role Gagal dihapus, karena masih terpakai table lain' );
        }

        if(Storage::exists('roles/'.$image)){
            Storage::delete('roles/'.$image);
        }

        return redirect()->back()->with('success', 'Data role dihapus');

    }
}
