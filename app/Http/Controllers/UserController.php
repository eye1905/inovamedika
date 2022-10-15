<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Session;
use Exception;
use Auth;
use App\Models\Role;
use App\Models\Staff;
use Hash;
use App\Helpers\StringHelper;
use Storage;
use App\Models\RoleUser;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 10;
        $roles = Session("role_id");

        if(isset($request->shareselect) and $request->shareselect != null){
            $page = $request->shareselect;
        }

        $data["data"] = User::with("staff")->orderBy("name", "asc")->paginate($page);
        $data["roles"] = RoleUser::getList();
        $data["filter"] = array("page" => $page);
        
        return view("user", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     $data["data"] = [];
     $data["staff"] = Staff::select("staff_id", "name")->get();
     $data["status"] = User::getStatus();

     if(Session("role_id") == "0"){
        $data["role"] = Role::select("role_id", "name")->get();
    }else{
        $data["role"] = Role::select("role_id", "name")->where("code", ">", "0")->get();
    }

    return view("form.user", $data);
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
            'staff_id'  => 'bail|nullable|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,staff_id',
            'role_id'  => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.roles,role_id',
            'username'  => 'bail|required|alpha_num|max:20|min:5|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.users,username',
            'password'  => 'bail|required|alpha_num|max:20|min:5',
            'gambar'  => 'bail|nullable|image|mimes:jpg,png,jpeg,gif,svg|max:1024',
            'status' => 'bail|required|in:active,inactive'
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
        }

        try {
            DB::beginTransaction();

            $user                   = new User();
            if(isset($request->staff_id) and $request->staff_id != null){
                $staff                  = Staff::findOrFail($request->staff_id);
                $user->name             = $staff->name;
                $user->email            = $staff->email;
                $user->phone            = $staff->phone;
                $user->staff_id            = $staff->staff_id;
            }
            
            $user->user_uuid        = StringHelper::generate_uuid();
            $user->username             = $request->username;
            $user->password             = Hash::make($request->password);
            $user->created_ip       = $request->ip();
            $user->status = $request->status;
            
            if($user->status == "active"){
                $user->account_verified_at = date("Y-m-d h:i:s");
            }
            
            if(isset(Auth::user()->user_id)){
                $user->created_by       = Auth::user()->user_id;
            }
            
            if(isset($request->gambar) and $request->file('gambar')!=null){
                $img = $request->file('gambar');
                
                $path_img = $img->store('profile');
                $image = explode("/", $path_img);
                $user->profile_picture = $image[1];
            }
            $user->save();

            // for role id
            $role =  new RoleUser();
            $role->user_id = $user->user_id;
            $role->role_id = $request->role_id;
            $role->created_ip       = $request->ip();

            if(isset(Auth::user()->user_id)){
                $role->created_by       = Auth::user()->user_id;
            }

            $role->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data user Gagal Disimpan' )->withInput($request->input());;
        }
        
        return redirect("user")->with('success', 'Data user Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        if(Storage::exists('profile/'.$user->profile_picture)){
            $path = 'profile/'.$user->profile_picture;

            $full_path = Storage::path($path);
            $base64 = base64_encode(Storage::get($path));
            $image = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
            $user->profile_picture = $image;
        }
        $cek =  RoleUser::where("user_id", $user->user_id)->get()->first();
        $user->role_id = $cek->role_id;
        $data["staff"] = Staff::select("staff_id", "name")->get();
        $data["data"] = $user;
        $data["status"] = User::getStatus();
        if(Session("role_id") == "1"){
            $data["role"] = Role::select("role_id", "name")->get();
        }else{
            $data["role"] = Role::select("role_id", "name")->where("code", ">", "1")->get();
        }

        return view("form.user", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if(Session("role_id") == "0"){
            $data["role"] = Role::select("role_id", "name")->get();
        }else{
            $data["role"] = Role::select("role_id", "name")->where("code", ">", "0")->get();
        }
        if(Storage::exists('profile/'.$user->profile_picture)){
            $path = 'profile/'.$user->profile_picture;
            
            $full_path = Storage::path($path);
            $base64 = base64_encode(Storage::get($path));
            $image = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
            $user->profile_picture = $image;
        }
        $cek =  RoleUser::where("user_id", $user->user_id)->get()->first();
        $user->role_id = $cek->role_id;
        $data["staff"] = Staff::select("staff_id", "name")->get();
        $data["data"] = $user;
        $data["status"] = User::getStatus();

        return view("form.user", $data);
    }

    public function profile(Request $request, $id){

        if($request->method()=="PUT"){

            $validator = Validator::make($request->all(), [
                'username'  => 'bail|required|alpha_num|max:20|min:5|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.users,username,'.$id.',user_id',
                'password'  => 'bail|nullable|alpha_num|max:20|min:5',
                'gambar'  => 'bail|nullable|image|mimes:jpg,png,jpeg,gif,svg|max:1024'
            ]);

            if ($validator->fails())
            {
                return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
            }

            try {
                DB::beginTransaction();

                $profile = User::findOrFail($id);
                
                $profile->username = $request->username;

                if(isset($request->password) and $request->password != null){
                    $profile->password = Hash::make($request->password);
                }
                
                if(isset(Auth::user()->user_id)){
                    $profile->updated_by       = Auth::user()->user_id;
                }
                
                if(isset($request->gambar) and $request->file('gambar')!=null){
                    if(Storage::exists('profile/'.$profile->profile_picture)){
                        Storage::delete('profile/'.$profile->profile_picture);
                    }
                    $img = $request->file('gambar');

                    $path_img = $img->store('profile');
                    $image = explode("/", $path_img);
                    $profile->profile_picture = $image[1];
                }
                
                $profile->save();

                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Data profile gagal diubah' )->withInput($request->input());;
            }

            return redirect("home")->with('success', 'Data profile berhasil diubah');
        }

        $user = User::with("staff")->findOrFail($id);
        if(Storage::exists('profile/'.$user->profile_picture)){
            $path = 'profile/'.$user->profile_picture;
            
            $full_path = Storage::path($path);
            $base64 = base64_encode(Storage::get($path));
            $image = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
            $user->profile_picture = $image;
        }

        $role = RoleUser::where("user_id", $user->user_id)->get()->first();
        $data["role"] = Role::where("role_id", $role->role_id)->get()->first();
        $data["data"] = $user;

        return view("form.profile-user", $data);
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
            'staff_id'  => 'bail|nullable|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,staff_id',
            'role_id'  => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.roles,role_id',
            'username'  => 'bail|required|alpha_num|max:20|min:5|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.users,username,'.$id.',user_id',
            'password'  => 'bail|nullable|alpha_num|max:20|min:5',
            'gambar'  => 'bail|nullable|image|mimes:jpg,png,jpeg,gif,svg|max:1024',
            'status' => 'bail|required|in:active,inactive'
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
        }

        try {
            DB::beginTransaction();
            $user                   = User::findOrFail($id);
            if(isset($request->staff_id) and $request->staff_id != null){
                $staff                  = Staff::findOrFail($request->staff_id);
                $user->name             = $staff->name;
                $user->email            = $staff->email;
                $user->phone            = $staff->phone;
                $user->staff_id            = $staff->staff_id;
            }
            $user->username             = $request->username;
            
            if($request->password != null){
                $user->password             = Hash::make($request->password);
            }
            
            $user->updated_ip       = $request->ip();
            $user->status = $request->status;

            if($user->status == "active"){
                $user->account_verified_at = date("Y-m-d h:i:s");
            }
            
            if(isset(Auth::user()->user_id)){
                $user->updated_by       = Auth::user()->user_id;
            }
            
            if(isset($request->gambar) and $request->file('gambar')!=null){
                if(Storage::exists('profile/'.$user->profile_picture)){
                    Storage::delete('profile/'.$user->profile_picture);
                }
                $img = $request->file('gambar');
                
                $path_img = $img->store('profile');
                $image = explode("/", $path_img);
                $user->profile_picture = $image[1];
            }

            $user->save();

            // this for role
            $cek =  RoleUser::where("user_id", $user->user_id)->get()->first();
            
            $role = RoleUser::findOrFail($cek->user_role_id);
            $role->role_id = $request->role_id;
            $role->updated_ip       = $request->ip();
            
            if(isset(Auth::user()->user_id)){
                $role->updated_by       = Auth::user()->user_id;
            }
            
            $role->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data user Gagal Disimpan' )->withInput($request->input());;
        }
        
        return redirect("user")->with('success', 'Data user Disimpan');
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
            $user                   = User::findOrFail($id);
            $image = $user->profile_picture;
            $user->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data user Gagal dihapus, karena masih terpakai table lain' );
        }
        
        if(Storage::exists('profile/'.$image)){
            Storage::delete('profile/'.$image);
        }

        return redirect()->back()->with('success', 'Data user dihapus');
    }
}
