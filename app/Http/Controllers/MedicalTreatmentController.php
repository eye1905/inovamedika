<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Staff;
use App\Models\Regions;
use App\Models\MedicalTreatment;
use DB;
use Session;
use Exception;
use Auth;
use Validator;
use Storage;
use App\Helpers\StringHelper;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
Use Response;
use Illuminate\Support\Facades\File;
use App\Exports\PasienExport;
use App\Models\Medicine;
use App\Models\Checkup;
use App\Models\MedicalCheckup;
use App\Models\MedicalMedicine;
use App\Models\Payment;

class MedicalTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perpage = $request->shareselect?$request->shareselect:10;
        $page = $request->dr_tgl?$request->sp_tgl:1;
        $f_patient_id = $request->f_patient_id?$request->f_patient_id:null;
        $f_medical_code = $request->f_medical_code?$request->f_medical_code:null;
        $f_status = $request->f_status?$request->f_status:null;
        $dr_tgl = $request->dr_tgl?$request->dr_tgl:date("Y-m-d");
        $sp_tgl = $request->dr_tgl?$request->sp_tgl:date("Y-m-T");

        $data["data"] = MedicalTreatment::getMedical($perpage, $page, $f_patient_id, $f_medical_code, $f_status, $dr_tgl, $sp_tgl);
        $data["filter"] = array("page" => $perpage);
        $data["metode"] = array("transfer" => "transfer",
                            "tunai" => "tunai",
                            "va" => "va",
                            "va" => "va",
                            "gopay" => "gopay",
                            "shopeepay" => "shopeepay",
                            "qris" => "qris");

        return view("medical", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'patient_id'  => 'bail|required|alphanum_spaces|max:255|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.patients,patient_id',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
        }
        
        $id = null;
        try {

            DB::beginTransaction();
            $medical = new MedicalTreatment();
            $medical->patient_id             = $request->patient_id;
            $medical->medical_code          = "MT-".StringHelper::random_number(9);
            $medical->date             = $request->date;
            $medical->nominal             = $request->nominal?$request->nominal:0;
            $medical->description       = $request->description;
            $medical->staff_id       = Auth::user()->staff_id;
            $medical->created_ip       = $request->ip();
            $medical->created_by = Auth::user()->user_id;
            $medical->is_payment = 0;
            $medical->status = 1;
            $medical->save();

            $id = $medical->medical_id;
            
            // this for tindakan
            $tindakan = count($request->checkup_id);
            $a_tindakan = $request->checkup_id;
            $a_description = $request->description_act;
            $checkup = [];
            for ($i = 0; $i < $tindakan; $i++) {
                $checkup[$i]["checkup_id"] = $a_tindakan[$i];
                $checkup[$i]["description"] = $a_description[$i];
                $checkup[$i]["medical_id"] = $id;
                $checkup[$i]["created_by"] = $medical->created_by;
                $checkup[$i]["created_ip"] = $medical->created_ip;
                $checkup[$i]["created_at"] = date("Y-m-d H:i:s");
            }

            MedicalCheckup::insert($checkup);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data pemeriksaan medis Gagal Disimpan'.$e->getMessage())->withInput($request->input());
        }
        
        return redirect("medical/".$id."/medicine")->with('success', 'Data pemeriksaan medis Disimpan');
    }

    public function saveobat(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'medicine_id'  => 'bail|required|alphanum_spaces|max:255|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.medicines,medicine_id',
            'jumlah'  => 'bail|nullable|numeric',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }
        
        try {
            DB::beginTransaction();
            $obat = Medicine::findOrFail($request->medicine_id);

            $medicine = new MedicalMedicine();
            $medicine->medicine_id = $request->medicine_id;
            $medicine->qty = $request->jumlah?$request->jumlah:1;
            $medicine->price = $medicine->qty*$obat->harga;
            $medicine->created_ip       = $request->ip();
            $medicine->created_by = Auth::user()->user_id;
            $medicine->medical_id = $id;
            $medicine->save();

            // sum all price medicine add to medical
            $sum = MedicalMedicine::where("medical_id", $id)->sum("price");

            $medical = MedicalTreatment::findOrFail($id);
            $medical->total = $medical->nominal + $sum;
            $medical->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data obat Gagal Disimpan'.$e->getMessage())->withInput($request->input());
        }
        
        return redirect()->back()->with('success', 'Data obat Disimpan');
    }

    public function updateobat(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'medicine_id'  => 'bail|required|alphanum_spaces|max:255|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.medicines,medicine_id',
            'jumlah'  => 'bail|nullable|numeric',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }
        
        try {
            DB::beginTransaction();
            $medicine = MedicalMedicine::findOrFail($id);
            $obat = Medicine::findOrFail($medicine->medicine_id);

            $medicine->medicine_id = $request->medicine_id;
            $medicine->qty = $request->jumlah?$request->jumlah:1;
            $medicine->price = $medicine->qty*$obat->harga;
            $medicine->created_ip       = $request->ip();
            $medicine->created_by = Auth::user()->user_id;
            $medicine->save();

            // sum all price medicine add to medical
            $sum = MedicalMedicine::where("medical_id", $medicine->medical_id)->sum("price");

            $medical = MedicalTreatment::findOrFail($medicine->medical_id);
            $medical->total = $medical->nominal + $sum;
            $medical->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data obat Gagal Disimpan'.$e->getMessage())->withInput($request->input());
        }
        
        return redirect()->back()->with('success', 'Data obat Disimpan');
    }

    public function deleteobat(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            $ide = null;
            $medicine = MedicalMedicine::findOrFail($id);
            $ide =  $medicine->medical_id;
            $medical = MedicalTreatment::findOrFail($ide);
            if($medical->status!="1"){
                return redirect()->back()->with('error', 'Invoice Tagihan sudah terbit');
            }
            $medicine->delete();
            
            // sum all price medicine add to medical
            $sum = MedicalMedicine::where("medical_id", $ide)->sum("price");

            $medical->total = $medical->nominal + $sum;
            $medical->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data obat Gagal dihapus'.$e->getMessage());
        }
        
        return redirect()->back()->with('success', 'Data obat dihapus');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $medical  = MedicalTreatment::findOrFail($id);
        $patients = Patients::findOrFail($medical->patient_id);
        $data['pasien']  = $patients;
        $data["data"] = $medical;
        $data["tindakan"] = Checkup::orderBy("name", "asc")->get();
        $data["obat"] = Medicine::orderBy("name", "asc")->get();
        $data["detail"] = MedicalMedicine::getDetail($id);
        //dd($data);
        return view("detail.medical", $data);
    }

    public function medicine($id)
    {
        $medical = MedicalTreatment::findOrFail($id);
        $patients = Patients::findOrFail($medical->patient_id);
        $data['pasien']  = $patients;
        $data["data"] = $medical;
        $data["tindakan"] = MedicalCheckup::getDetail($id);
        $data["obat"] = Medicine::orderBy("name", "asc")->get();
        $data["detail"] = MedicalMedicine::getDetail($id);

        return view("detail.medical", $data);
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

    public function generate($id)
    {
        try {

            DB::beginTransaction();
            $medical = MedicalTreatment::findOrFail($id);
            $medical->status = 2;
            $medical->updated_by = Auth::user()->user_id;
            $medical->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Tagihan gagal digenerate');
        }
        
        return redirect()->back()->with('success', 'Tagihan sudah digenerate');
    }

    public function payment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'method'  => 'bail|required|in:transfer,tunai,va,gopay,shopeepay,ovo,qris',
            'name'  => 'bail|nullable|max:100',
            'number'  => 'bail|nullable|max:100',
            'nominal'  => 'bail|required|digits_between:0,20',
            'date'  => 'bail|required|date_format:Y-m-d',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }

        try {

            DB::beginTransaction();
            $medical = MedicalTreatment::findOrFail($id);
            if($medical->total < $request->nominal){
                return redirect()->back()->with('error', 'Tagihan nominal yang dibayarkan harus sama');
            }

            $medical->status = 3;

            $payment = new Payment();
            $payment->payment_code = "PM-".StringHelper::random_number(9);
            $payment->medical_id = $id;
            $payment->staff_id = Auth::user()->staff_id;
            $payment->method = $request->method;
            $payment->nominal = $request->nominal;
            $payment->date = $request->date;
            $payment->name = $request->name;
            $payment->number = $request->number;
            $payment->created_ip       = $request->ip();
            $payment->created_by = Auth::user()->user_id;
            $payment->save();

            $medical->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Tagihan gagal dibayar'.$e->getMessage())->withInput($request->input());
        }
        
        return redirect()->back()->with('success', 'Tagihan sudah dibayar');
    }
}
