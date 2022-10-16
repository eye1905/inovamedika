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
use App\Models\RolePermition;
use App\Models\Navigations;

class PermitionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 10;
        $role_id = null;
        $navigation_id = null;

        $permit = RolePermition::select("*");
        if(isset($request->shareselect) and $request->shareselect != null){
            $page = $request->shareselect;
        }

        if(isset($request->navigation_id) and $request->navigation_id != null){
            $navigation_id = $request->navigation_id;
            $permit->where("navigation_id", $navigation_id);
        }

        if(isset($request->role_id) and $request->role_id != null){
            $role_id = $request->role_id;
            $permit->where("role_id", $role_id);
        }

        $data["role"] = Role::getList();
        $data["menu"] = Navigations::select("navigation_id", "name")->orderBy("position", "asc")->get();
        $data["data"] = $permit->paginate($page);
        $data["filter"] = array("page" => $page,
                                "navigation_id" => $navigation_id,
                                "role_id" => $role_id);

        return view("permition", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data["role"] = Role::getList();
        $data["menu"] = Navigations::select("navigation_id", "name")->get();
        $data["data"] = [];

        return view("form.permition", $data);
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
            'role_id'  => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.roles,role_id',
            'navigation_id'  => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.navigations,navigation_id',
            'read' => 'bail|nullable|numeric|max:1',
            'create' => 'bail|nullable|numeric|max:1',
            'update' => 'bail|nullable|numeric|max:1',
            'delete' => 'bail|nullable|numeric|max:1',
            'detail' => 'bail|nullable|numeric|max:1',
            'import' => 'bail|nullable|numeric|max:1',
            'export' => 'bail|nullable|numeric|max:1',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }

        $cek = RolePermition::where("navigation_id", $request->navigation_id)
        ->where("role_id", $request->role_id)
        ->get()->first();
        
        if($cek != null){
            return redirect()->back()->with('error', "role permission menu sudah ada")->withInput($request->input());;
        }

        try {
            DB::beginTransaction();
            $roles                   = new RolePermition();
            $roles->role_id             = $request->role_id;
            $roles->navigation_id             = $request->navigation_id;
            $roles->read_permission             = $request->read;
            $roles->create_permission             = $request->create;
            $roles->update_permission             = $request->update;
            $roles->delete_permission             = $request->delete;
            $roles->detail_permission             = $request->detail;
            $roles->import_permission             = $request->import;
            $roles->export_permission             = $request->export;

            $roles->created_ip       = $request->ip();

            if(isset(Auth::user()->user_id)){
                $roles->created_by       = Auth::user()->user_id;
            }
            $roles->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data role permission disimpan' )->withInput($request->input());
        }
        
        return redirect("permition")->with('success', 'Data role permission disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PermitionsController  $permitionsController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data["role"] = Role::getList();
        $data["menu"] = Navigations::select("navigation_id", "name")->get();
        $data["data"] = RolePermition::findOrFail($id);

        return view("form.permition", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PermitionsController  $permitionsController
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data["role"] = Role::getList();
        $data["menu"] = Navigations::select("navigation_id", "name")->get();
        $data["data"] = RolePermition::findOrFail($id);

        return view("form.permition", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PermitionsController  $permitionsController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'read' => 'bail|nullable|numeric|max:1',
            'create' => 'bail|nullable|numeric|max:1',
            'update' => 'bail|nullable|numeric|max:1',
            'delete' => 'bail|nullable|numeric|max:1',
            'detail' => 'bail|nullable|numeric|max:1',
            'import' => 'bail|nullable|numeric|max:1',
            'export' => 'bail|nullable|numeric|max:1',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }

        try {
            DB::beginTransaction();
            $roles                   = RolePermition::findOrFail($id);
            $roles->read_permission             = $request->read;
            $roles->create_permission             = $request->create;
            $roles->update_permission             = $request->update;
            $roles->delete_permission             = $request->delete;
            $roles->detail_permission             = $request->detail;
            $roles->import_permission             = $request->import;
            $roles->export_permission             = $request->export;

            $roles->created_ip       = $request->ip();

            if(isset(Auth::user()->user_id)){
                $roles->created_by       = Auth::user()->user_id;
            }
            $roles->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data role permission disimpan' )->withInput($request->input());
        }
        
        return redirect("permition")->with('success', 'Data role permission disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PermitionsController  $permitionsController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            DB::beginTransaction();
            $user                   = RolePermition::findOrFail($id);
            $user->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data role permission Gagal dihapus, karena masih terpakai table lain' );
        }

        return redirect()->back()->with('success', 'Data role permission dihapus');
    }
}
