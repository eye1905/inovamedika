<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Navigations;
use DB;
use Session;
use Exception;
use Auth;
use Validator;
use File;
use Illuminate\Support\Facades\Storage;
use Hash;

class NavigationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["data"] = Navigations::getList(1);
        $level2 = Navigations::getList(2);
        
        $level = [];
        foreach($level2 as $key => $value){
            $level[$value->parent_navigation_id][$key] = $value;
        }
        
        $data["level2"] = $level;

        return view("navigations", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data["data"] = [];
        $data["parent"] = Navigations::getMenu(1);
        
        return view("form.navigations", $data);
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
            'name'  => 'bail|required|alpha_spaces|max:100|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.navigations,name',
            'description'  => 'bail|nullable|max:100',
            'icon'  => 'bail|required|max:50',
            'uri'  => 'bail|nullable|max:100|alpha|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.navigations,uri',
            'is_master'  => 'bail|nullable|numeric|max:1',
            'parent'  => 'bail|nullable|numeric|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.navigations,navigation_id',
            'controller'  => 'bail|alpha|nullable|max:100',
            'level'  => 'bail|required|numeric|max:2',
            'is_show' => 'bail|nullable|numeric|min:0|max:1'
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }
        
        try {
            $position = Navigations::select("position")->orderBy("position", "desc")->first();
            
            DB::beginTransaction();
            $menu                   = new Navigations();
            $menu->name             = $request->name;
            $menu->description      = $request->description;
            $menu->controller      = $request->controller;
            $menu->icon             = $request->icon;
            $menu->uri             = $request->uri;
            $menu->is_master             = $request->is_master;
            $menu->parent_navigation_id             = $request->parent;
            $menu->level             = $request->level;
            $menu->created_ip       = $request->ip();

            if($position==null){
                $menu->position = 1;
            }else{
                $menu->position = $position->position+1;
            }
            
            if(isset(Auth::user()->user_id)){
                $menu->created_by       = Auth::user()->user_id;
            }
            $menu->is_show = $request->is_show;
            $menu->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data Menu Gagal Disimpan' )->withInput($request->input());;
        }

        return redirect("menu")->with('success', 'Data Menu Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data["data"] = Navigations::findOrFail($id);
        $data["parent"] = Navigations::getMenu(1);
        
        return view("form.navigations", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data["data"] = Navigations::findOrFail($id);
        $data["parent"] = Navigations::getMenu(1);
        
        return view("form.navigations", $data);
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
            'name'  => 'bail|required|alpha_spaces|max:100|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.navigations,name,'.$id.',navigation_id',
            'description'  => 'bail|nullable|max:100',
            'icon'  => 'bail|required|max:50',
            'uri'  => 'bail|nullable|max:100|alpha|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.navigations,uri,'.$id.',navigation_id',
            'is_master'  => 'bail|nullable|numeric|max:1',
            'parent'  => 'bail|nullable|numeric',
            'controller'  => 'bail|alpha|nullable|max:100',
            'level'  => 'bail|required|numeric|max:2',
            'is_show' => 'bail|nullable|numeric|min:0|max:1'
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }
        
        try {

            DB::beginTransaction();
            $menu                   = Navigations::findOrFail($id);
            $menu->name             = $request->name;
            $menu->description      = $request->description;
            $menu->controller      = $request->controller;
            $menu->icon             = $request->icon;
            $menu->uri             = $request->uri;
            $menu->is_master             = $request->is_master;
            $menu->parent_navigation_id             = $request->parent;
            $menu->level             = $request->level;
            $menu->updated_ip       = $request->ip();

            if(isset(Auth::user()->user_id)){
                $menu->updated_by       = Auth::user()->user_id;
            }
            $menu->is_show = $request->is_show;
           // dd($menu);
            $menu->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data Menu Gagal Disimpan' )->withInput($request->input());;
        }

        return redirect("menu")->with('success', 'Data Menu Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        try {

            $menu = Navigations::findOrFail($id);
            $menu->delete();

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Menu gagal di Hapus');
        }

        return redirect()->back()->with('success', 'Data Menu Hapus');
    }

    public function up($id)
    {
        $menu = Navigations::findOrFail($id);
        $menu2 = Navigations::getUpPosition($menu->level, $menu->position, $menu->parent_navigation_id);
        //dd($menu2);
        if($menu2 == null){
            return redirect()->back()->with('error', 'Posisi Menu sudah paling atas');
        }

        DB::beginTransaction();
        try {
            //tukar position menu awal ke pindahan
            $a_menu1 = [];
            $a_menu1["position"] = $menu2->position;

            //tukar position menu pindahan ke menu awal
            $a_menu2 = [];
            $a_menu2["position"] = $menu->position;

            Navigations::where("navigation_id", $menu->navigation_id)->update($a_menu1);
            Navigations::where("navigation_id", $menu2->navigation_id)->update($a_menu2);

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Posisi menu gagal di pindah, ');
        }

        return redirect()->back()->with('success', 'Data Menu dipindah');
    }
    
    public function down($id)
    {
        $menu = Navigations::findOrFail($id);
        $menu2 = Navigations::getDownPosition($menu->level, $menu->position, $menu->parent_navigation_id);
        
        if($menu2 == null){
            return redirect()->back()->with('error', 'Posisi Menu sudah paling atas');
        }

        DB::beginTransaction();
        try {
            //tukar position menu awal ke pindahan
            $a_menu1 = [];
            $a_menu1["position"] = $menu2->position;

            //tukar position menu pindahan ke menu awal
            $a_menu2 = [];
            $a_menu2["position"] = $menu->position;
            
            Navigations::where("navigation_id", $menu->navigation_id)->update($a_menu1);
            Navigations::where("navigation_id", $menu2->navigation_id)->update($a_menu2);
            
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Posisi menu gagal di pindah, ');
        }

        return redirect()->back()->with('success', 'Data Menu dipindah');
    }
}
