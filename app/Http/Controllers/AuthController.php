<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Exception;
use App\Models\User;
use App\Models\Role;
use App\Models\RolePermition;
use Session;
use Storage;

class AuthController extends Controller
{
    public function __construct()
    {   
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        if ($request->method()=="POST"){

            if(Auth::attempt(array(
                'username' => $request->username,
                'password' => $request->password
            ))){
                
                if(Auth::user()->status != "active"){
                    Auth::logout();
                    return redirect('auth')->with('error', 'Status user belum active');
                }
                
                $roles = Role::findOrFail(Auth::user()->role_id);
                
                $session = [];
                $session["role_id"] = $roles->code;
                Session($session);
                
                return redirect("home")->with('success', 'Selamat Datang Di Klinik Nawasena');
            }else{
                return redirect("auth")->with('error', 'username dan password tidak terdaftar');
            }
        }
        
        return view("auth.login");
    }
    
    public function logout()
    {
        Auth::logout();

        if(isset($id) && $id !=null){
            return redirect('auth')->with('error', $id);
        }else{
            return redirect('auth')->with('success', 'Anda keluar Aplikasi Klinik Nawasena');
        }
    }
    
    public function register()
    {
        abort(404);
    }
}
