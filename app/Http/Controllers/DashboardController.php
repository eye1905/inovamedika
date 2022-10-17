<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Session;
use DB;
use Exception;
use App\Models\Role;
use App\Models\Patients;
use App\Models\MedicalTreatment;
use App\Models\Staff;
use App\Models\Payment;
use App\Models\Medicine;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start_date = $request->start_date?$request->start_date:date('Y-01-01');
        $end_date = $request->end_date?$request->end_date:date('Y-12-t');

        $data["user"] = Staff::where("entry_year", ">=", $start_date)->where("entry_year", "<=", $end_date)->count();
        $data["pasien"] = Patients::where("first_entry", ">=", $start_date)->where("first_entry", "<=", $end_date)->count();
        $data["medical"] = MedicalTreatment::where("date", ">=", $start_date)->where("date", "<=", $end_date)->count();
        $data["payment"] = Payment::where("date", ">=", $start_date)->where("date", "<=", $end_date)->sum("nominal");
        $data["obat"]  = Medicine::select("name", "medicine_id")->orderBy("name", "asc")->get();
        $statsobat = Medicine::getStatistik($start_date, $end_date);
        $sumobat = Medicine::getSumStatistik($start_date, $end_date);

        $totalobat = 0;
        foreach($statsobat as $key => $value){
            $totalobat += $value->jumlah;
        }
        $sumtotalobat = 0;
        foreach($sumobat as $key => $value){
            $sumtotalobat += $value->jumlah;
        }
        $data["usia"] = Patients::getusia();
        $data["statsobat"] = $statsobat;
        $data["totalobat"] = $totalobat;
        $data["sumobat"] = $sumobat;
        $data["sumtotalobat"] = $sumtotalobat;
        $data["filter"] = array(
                            "start_date" => $start_date,
                            "end_date" => $end_date);

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
