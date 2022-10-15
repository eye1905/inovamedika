<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Session;
use DB;
use Exception;
use App\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $data["user"] = 0;
       $data["pasien"] = 0;
       $data["terapis"] = 0;
       $data["jadwal"]  = [];
       $data["kelaminpasien"] = [];
       $data["usia"] = [];
       $data["pengumuman"] = [];
       $data["doctor"] = 0;
       $data["diagnosa"] = [];
       $data["intervensi"] = [];
       $data["paket"] = [];
       $data["fisio"] = [];

       return view("dashboard", $data);
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
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
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }

    public function bypass($id = null)
    {
        if(Auth::user()->is_by_pass!="1"){
            return redirect()->back()->with('error', 'Halaman ini hanya bisa di akses developer');
        }

        if($id==null){
            $data["user"] = User::with("staff")->orderBy("name", "asc")->get();
            $data["roles"] = RoleUser::getList();

            return view("bypass", $data);
        }else{

            $user = User::findOrFail($id);
            Auth::login($user);

            if(Auth::user()->status != "active"){
                Auth::logout();
                return redirect('auth')->with('error', 'Status user belum active');
            }

            $role = RoleUser::where("user_id", Auth::user()->user_id)->orderBy("created_at", "asc")->get()->first();

            $roles = Role::findOrFail($role->role_id);

            $session = [];
            $session["role_id"] = $roles->code;
            $session["is_self"] = $roles->is_self;
            Session($session);

            return redirect("home")->with('success', 'Selamat Datang Di Klinik Nawasena');
        }
    }
}
